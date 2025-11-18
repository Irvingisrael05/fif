<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

// Modelos
use App\Models\Persona;
use App\Models\Localidad;
use App\Models\Equipo;
use App\Models\Coordinador;
use App\Models\Arbitro;
use App\Models\Jugador;

class RegistroController extends Controller
{
    /**
     * Formulario de registro
     */
    public function form()
    {
        // Equipos: lo dejo por compatibilidad con cualquier blade que lo use.
        $equipos = Equipo::select('id_equipo as id','nombre')
            ->orderBy('nombre','asc')->get();

        // NUEVO: lista para el <select> de localidades en la vista
        $localidades = Localidad::orderBy('comunidad','asc')
            ->get(['id_localidad','comunidad']);

        return view('registro', compact('equipos', 'localidades'));
    }

    /**
     * Guardado
     * - Jugador: equipo = NULL, estado = Pendiente (dorsal/posicion del registro)
     * - Árbitro: estado calculado por vigencia
     * - Coordinador: crea código de acceso
     */
    public function store(Request $r)
    {
        $rules = [
            'nombre'            => ['required','string','max:100'],
            'apellido_paterno'  => ['required','string','max:100'],
            'apellido_materno'  => ['required','string','max:100'],
            'fecha_nacimiento'  => ['required','date'],
            'curp'              => ['required','string','size:18'],
            'email'             => ['required','email','max:150','unique:personas,correo'],

            // ✅ Acepta EITHER localidad_id (select) OR localidad (texto)
            'localidad_id'      => ['required_without:localidad','nullable','integer','exists:localidades,id_localidad'],
            'localidad'         => ['required_without:localidad_id','nullable','string','max:150'],

            'telefono'          => ['nullable','regex:/^[0-9]{10}$/'],
            'password'          => ['required','string','min:6'],
            'confirm_password'  => ['required','string','min:6'],
            'tipo_usuario'      => ['required','in:jugador,arbitro,coordinador'],
        ];

        if ($r->tipo_usuario === 'jugador') {
            $rules = array_merge($rules, [
                'dorsal'   => ['required','integer','min:1','max:99'],
                'posicion' => ['required','in:Delantero,Mediocampista,Defensa,Portero'],
            ]);
        } elseif ($r->tipo_usuario === 'arbitro') {
            $rules = array_merge($rules, [
                'licencia'          => ['required','string','max:100'],
                'anios_experiencia' => ['required','integer','min:0','max:50'],
                'vigencia_licencia' => ['required','date'],
            ]);
        } elseif ($r->tipo_usuario === 'coordinador') {
            $rules = array_merge($rules, [
                'codigo_admin' => ['required','string','max:50'],
            ]);
        }

        $r->validate($rules);

        if ($r->input('password') !== $r->input('confirm_password')) {
            return back()->withErrors(['confirm_password' => 'La confirmación de contraseña no coincide.'])->withInput();
        }

        DB::transaction(function () use ($r) {
            // ✅ Si viene el select, lo uso; si no, mantengo el flujo anterior
            $idLocalidad = $r->filled('localidad_id')
                ? (int) $r->input('localidad_id')
                : $this->ensureLocalidad((string) $r->input('localidad'));

            // Inserta Persona (mapea a tus columnas reales)
            $persona = Persona::create([
                'nombre'               => $r->input('nombre'),
                'apaterno'             => $r->input('apellido_paterno'),
                'amaterno'             => $r->input('apellido_materno'),
                'fecha_de_nacimiento'  => $r->input('fecha_nacimiento'),
                'correo'               => $r->input('email'),
                'id_localidad'         => $idLocalidad,
                'curp'                 => strtoupper($r->input('curp')),
                // Si tu tabla tiene 'telefono', descomenta esta línea:
                // 'telefono'             => $r->input('telefono'),
                'password'             => Hash::make($r->input('password')),
                'tipo_de_usuario'      => $this->mapTipoUsuario($r->input('tipo_usuario')),
            ]);

            $tipo = $r->input('tipo_usuario');

            if ($tipo === 'coordinador') {
                $codigo = $this->resolverCodigoAcceso($r->input('codigo_admin'));
                $intentos = 3;
                for ($i=0; $i<$intentos; $i++) {
                    try {
                        Coordinador::create([
                            'id_persona'       => $persona->id_persona,
                            'codigo_de_acceso' => $codigo,
                        ]);
                        break;
                    } catch (\Illuminate\Database\QueryException $ex) {
                        if ($this->esDuplicado($ex)) { $codigo = $this->generarCodigoAleatorio(); continue; }
                        throw $ex;
                    }
                }

            } elseif ($tipo === 'arbitro') {
                $estado = $this->calcularEstadoArbitro($r->input('vigencia_licencia'));
                Arbitro::create([
                    'persona'           => $persona->id_persona,
                    'licencia'          => $r->input('licencia'),
                    'anios_experiencia' => (int)$r->input('anios_experiencia'),
                    'vigencia_licencia' => $r->input('vigencia_licencia'),
                    'estado'            => $estado,
                ]);

            } elseif ($tipo === 'jugador') {
                // equipo NULL + estado Pendiente; dorsal/posicion del formulario
                Jugador::create([
                    'persona'  => $persona->id_persona,
                    'equipo'   => null,
                    'dorsal'   => (int)$r->input('dorsal'),
                    'posicion' => $r->input('posicion'),
                    'estado'   => 'Pendiente',
                ]);
            }
        });

        return redirect()->route('login.form')
            ->with('ok', 'Registro enviado correctamente. Si eres jugador, tu solicitud será revisada por el coordinador.');
    }

    private function ensureLocalidad(string $comunidad): int
    {
        $comunidad = trim($comunidad);
        $l = Localidad::where('comunidad', $comunidad)->first();
        if ($l) return (int)$l->id_localidad;

        $nueva = Localidad::create(['comunidad' => $comunidad]);
        return (int)$nueva->id_localidad;
    }

    private function mapTipoUsuario(string $tipo): string
    {
        return match ($tipo) {
            'jugador'     => 'Jugador',
            'arbitro'     => 'Arbitro',
            'coordinador' => 'Coordinador',
            default       => 'Jugador',
        };
    }

    private function calcularEstadoArbitro(string $vigencia): string
    {
        try {
            $hoy = Carbon::now()->startOfDay();
            $fv  = Carbon::parse($vigencia)->startOfDay();
            return $fv->greaterThanOrEqualTo($hoy) ? 'Activo' : 'Inactivo';
        } catch (\Throwable $e) {
            return 'Inactivo';
        }
    }

    private function resolverCodigoAcceso(?string $codigo): int
    {
        $digs = preg_replace('/\D+/', '', $codigo ?? '');
        if ($digs === '' || (int)$digs === 0) return $this->generarCodigoAleatorio();
        return (int)$digs;
    }

    private function generarCodigoAleatorio(): int
    {
        return random_int(2000, 999999);
    }

    private function esDuplicado(\Illuminate\Database\QueryException $ex): bool
    {
        return str_contains($ex->getMessage(), '1062');
    }
}
