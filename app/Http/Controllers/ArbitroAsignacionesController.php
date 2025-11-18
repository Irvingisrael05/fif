<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ArbitroAsignacionesController extends Controller
{
    /* ================== 1) PARTIDOS ASIGNADOS (vista del árbitro) ================== */
    public function index(Request $r) {
        $rol = session('user_rol');
        $idPersona = session('user_id');

        // obtener id_arbitro a partir de la persona
        $idArbitro = DB::table('arbitros')->where('persona', $idPersona)->value('id_arbitro');

        $partidos = DB::table('partido as p')
            ->join('equipos as el','el.id_equipo','=','p.equipo_local')
            ->join('equipos as ev','ev.id_equipo','=','p.equipo_visitante')
            ->join('torneos as t','t.id_torneo','=','p.id_torneo')
            ->where('p.id_arbitro',$idArbitro)
            ->orderBy('p.fecha','desc')
            ->select('p.*','el.nombre as local','ev.nombre as visitante','t.nombre as torneo')
            ->get();

        return view('partidos_asignados_arbitros', compact('partidos'));
    }

    /* ================== Helpers compartidos ================== */
    private function estadoDesdeVigencia(?string $vigencia): string
    {
        if (!$vigencia) return 'Inactivo';
        $hoy = Carbon::today();
        $fin = Carbon::parse($vigencia);
        if ($fin->isPast()) return 'Inactivo';
        if ($hoy->diffInDays($fin, false) <= 60) return 'Por vencer';
        return 'Activo';
    }

    private function splitNombre(string $full): array
    {
        $full = trim(preg_replace('/\s+/', ' ', $full));
        if ($full === '') return ['','',''];
        $parts = explode(' ', $full);
        if (count($parts) === 1) return [$parts[0],'',''];
        if (count($parts) === 2) return [$parts[0], $parts[1], ''];
        $amaterno = array_pop($parts);
        $apaterno = array_pop($parts);
        $nombre   = implode(' ', $parts);
        return [$nombre, $apaterno, $amaterno];
    }

    private function selectArbitroQuery()
    {
        return DB::table('arbitros as a')
            ->leftJoin('personas as p', 'p.id_persona', '=', 'a.persona')
            ->leftJoin('localidades as l', 'l.id_localidad', '=', 'p.id_localidad')
            ->select(
                'a.id_arbitro','a.licencia','a.anios_experiencia','a.vigencia_licencia','a.estado',
                'p.id_persona','p.nombre','p.apaterno','p.amaterno','p.correo',
                'p.curp','p.fecha_de_nacimiento','l.comunidad as localidad','p.id_localidad'
            );
    }

    /* ================== 2) CRUD para el modal del coordinador ================== */

    // GET /arbitros
    public function arbitrosIndex(Request $request)
    {
        $items = $this->selectArbitroQuery()
            ->orderBy('a.id_arbitro','asc')
            ->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['ok'=>true,'arbitros'=>$items]);
        }
        // Si algún día lo abres como vista independiente:
        return view('arbitros.index', ['arbitros' => $items]);
    }

    // POST /arbitros
    public function arbitrosStore(Request $request)
    {
        $request->validate([
            'nombre_full'        => 'required|string|max:160',
            'licencia'           => 'required|string|max:50',
            'anios_experiencia'  => 'required|integer|min:0|max:80',
            'vigencia_licencia'  => 'required|date',
            'correo'             => 'nullable|email|max:120',
            'id_localidad'       => 'required|integer|exists:localidades,id_localidad',
            'curp'               => 'required|string|max:18',
            'fecha_nacimiento'   => 'required|date',
            'password'           => 'required|string|min:4|max:60'
        ]);

        [$nombre,$apaterno,$amaterno] = $this->splitNombre($request->nombre_full);
        $estado = $this->estadoDesdeVigencia($request->vigencia_licencia);

        // Persona
        $idPersona = DB::table('personas')->insertGetId([
            'nombre'               => $nombre,
            'apaterno'             => $apaterno,
            'amaterno'             => $amaterno,
            'correo'               => $request->input('correo'),
            'id_localidad'         => $request->input('id_localidad'),
            'curp'                 => $request->input('curp'),
            'fecha_de_nacimiento'  => $request->input('fecha_nacimiento'),
            'password'             => bcrypt($request->input('password')),
        ]);

        // Árbitro
        $idArb = DB::table('arbitros')->insertGetId([
            'persona'            => $idPersona,
            'licencia'           => $request->licencia,
            'anios_experiencia'  => $request->anios_experiencia,
            'vigencia_licencia'  => $request->vigencia_licencia,
            'estado'             => $estado,
        ]);

        $row = $this->selectArbitroQuery()->where('a.id_arbitro', $idArb)->first();

        return response()->json(['ok'=>true,'arbitro'=>$row]);
    }

    // PUT /arbitros/{id}
    public function arbitrosUpdate(Request $request, $id)
    {
        $arb = DB::table('arbitros')->where('id_arbitro',$id)->first();
        if (!$arb) return response()->json(['ok'=>false,'message'=>'Árbitro no encontrado'],404);

        $request->validate([
            'nombre_full'        => 'nullable|string|max:160',
            'licencia'           => 'nullable|string|max:50',
            'anios_experiencia'  => 'nullable|integer|min:0|max:80',
            'vigencia_licencia'  => 'nullable|date',
            'correo'             => 'nullable|email|max:120',
            'id_localidad'       => 'nullable|integer|exists:localidades,id_localidad',
            'curp'               => 'nullable|string|max:18',
            'fecha_nacimiento'   => 'nullable|date',
            'password'           => 'nullable|string|min:4|max:60',
            'estado'             => 'nullable|in:Activo,Por vencer,Inactivo',
        ]);

        // Persona
        if ($arb->persona) {
            $personaUpd = [];
            if ($request->filled('nombre_full')) {
                [$nombre,$apaterno,$amaterno] = $this->splitNombre($request->nombre_full);
                $personaUpd += compact('nombre','apaterno','amaterno');
            }
            foreach (['correo','id_localidad','curp'] as $f) {
                if ($request->filled($f)) $personaUpd[$f] = $request->input($f);
            }
            if ($request->filled('fecha_nacimiento')) {
                $personaUpd['fecha_de_nacimiento'] = $request->input('fecha_nacimiento');
            }
            if ($request->filled('password')) {
                $personaUpd['password'] = bcrypt($request->input('password'));
            }
            if (!empty($personaUpd)) {
                DB::table('personas')->where('id_persona',$arb->persona)->update($personaUpd);
            }
        }

        // Árbitro
        $arbUpd = [];
        if ($request->filled('licencia'))           $arbUpd['licencia'] = $request->licencia;
        if ($request->filled('anios_experiencia'))  $arbUpd['anios_experiencia'] = $request->anios_experiencia;
        if ($request->filled('vigencia_licencia')) {
            $arbUpd['vigencia_licencia'] = $request->vigencia_licencia;
            if (!$request->filled('estado')) {
                $arbUpd['estado'] = $this->estadoDesdeVigencia($request->vigencia_licencia);
            }
        }
        if ($request->filled('estado')) $arbUpd['estado'] = $request->estado;

        if (!empty($arbUpd)) {
            DB::table('arbitros')->where('id_arbitro',$id)->update($arbUpd);
        }

        $row = $this->selectArbitroQuery()->where('a.id_arbitro',$id)->first();
        return response()->json(['ok'=>true,'arbitro'=>$row]);
    }

    // DELETE /arbitros/{id}
    public function arbitrosDestroy($id)
    {
        if (!DB::table('arbitros')->where('id_arbitro',$id)->exists()) {
            return response()->json(['ok'=>false,'message'=>'Árbitro no encontrado'],404);
        }
        DB::table('arbitros')->where('id_arbitro',$id)->delete();
        return response()->json(['ok'=>true]);
    }
}
