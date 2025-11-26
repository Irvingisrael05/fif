<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Partido;

class PartidoController extends Controller
{
    /**
     * Vista: Programar Partidos
     */
    public function create()
    {
        // === TORNEOS ===
        $torneos = DB::table('torneos')
            ->orderBy('fecha_inicio','desc')
            ->get(['id_torneo','nombre','fecha_inicio','fecha_fin']);

        // === EQUIPOS ===
        $equipos = DB::table('equipos')
            ->orderBy('nombre','asc')
            ->get(['id_equipo','nombre']);

        // === CANCHAS (columnas tolerantes) ===
        $canchasCols = ['id_cancha','nombre'];

        $colLocalidad = Schema::hasColumn('canchas','localidad') ? 'localidad' :
            (Schema::hasColumn('canchas','id_localidad') ? 'id_localidad' : null);
        $colDireccion = Schema::hasColumn('canchas','direccion') ? 'direccion' :
            (Schema::hasColumn('canchas','ubicacion') ? 'ubicacion' : null);

        if ($colLocalidad) $canchasCols[] = $colLocalidad . ' as id_localidad';
        if ($colDireccion) $canchasCols[] = $colDireccion . ' as direccion';
        if (Schema::hasColumn('canchas','capacidad'))  $canchasCols[] = 'capacidad';
        if (Schema::hasColumn('canchas','telefono'))   $canchasCols[] = 'telefono';
        if (Schema::hasColumn('canchas','condiciones'))$canchasCols[] = 'condiciones';

        $canchas = DB::table('canchas')->orderBy('nombre','asc')->get($canchasCols);

        // === LOCALIDADES para el select del modal ===
        $localidades = DB::table('localidades')
            ->orderBy('comunidad','asc')
            ->get(['id_localidad','comunidad']);

        // === ÁRBITROS: usando tu BD real (arbitros.persona -> personas.id_persona) ===
        $arbitros = DB::table('arbitros')
            ->join('personas', 'personas.id_persona', '=', 'arbitros.persona')
            ->orderBy('personas.nombre', 'asc')
            ->orderBy('personas.apaterno', 'asc')
            ->get([
                'arbitros.id_arbitro',
                DB::raw("CONCAT(personas.nombre,' ',personas.apaterno,' ',personas.amaterno) AS nombre")
            ]);

        return view('programar_partidos', compact(
            'torneos','equipos','canchas','localidades','arbitros'
        ));
    }

    /**
     * Guardar partido
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_torneo'        => 'required|integer|exists:torneos,id_torneo',
            'jornada'          => 'required|integer|min:1',
            'equipo_local'     => 'required|integer|exists:equipos,id_equipo',
            'equipo_visitante' => 'required|integer|exists:equipos,id_equipo|different:equipo_local',
            'id_cancha'        => 'required|integer|exists:canchas,id_cancha',
            'id_arbitro'       => 'required|integer|exists:arbitros,id_arbitro',
            'fecha'            => 'required|date',
            'hora'             => 'required'
        ]);

        Partido::create([
            'id_torneo'        => $request->id_torneo,
            'jornada'          => $request->jornada,
            'equipo_local'     => $request->equipo_local,
            'equipo_visitante' => $request->equipo_visitante,
            'id_cancha'        => $request->id_cancha,
            'id_arbitro'       => $request->id_arbitro,
            'fecha'            => $request->fecha,
            'hora'             => $request->hora,
        ]);

        return redirect()->back()->with('ok', 'Partido programado correctamente.');
    }

    /**
     * API: Mostrar info de cancha
     */
    public function canchaShow($id)
    {
        $colDireccion = Schema::hasColumn('canchas','direccion') ? 'direccion' :
            (Schema::hasColumn('canchas','ubicacion') ? 'ubicacion' : null);
        $colLocalidad = Schema::hasColumn('canchas','localidad') ? 'localidad' :
            (Schema::hasColumn('canchas','id_localidad') ? 'id_localidad' : null);

        $sel = ['id_cancha','nombre'];
        if ($colDireccion) $sel[] = "$colDireccion as direccion";
        if ($colLocalidad) $sel[] = "$colLocalidad as id_localidad";
        if (Schema::hasColumn('canchas','capacidad'))   $sel[] = 'capacidad';
        if (Schema::hasColumn('canchas','telefono'))    $sel[] = 'telefono';
        if (Schema::hasColumn('canchas','condiciones')) $sel[] = 'condiciones';

        $cancha = DB::table('canchas')->where('id_cancha',$id)->first($sel);

        if (!$cancha) {
            return response()->json(['ok'=>false,'message'=>'Cancha no encontrada'], 404);
        }

        $localidadNombre = null;
        if ($colLocalidad && isset($cancha->id_localidad) && Schema::hasTable('localidades')) {
            $loc = DB::table('localidades')->where('id_localidad',$cancha->id_localidad)->first(['comunidad']);
            $localidadNombre = $loc?->comunidad;
        }

        return response()->json([
            'ok'   => true,
            'data' => [
                'id_cancha'  => $cancha->id_cancha,
                'nombre'     => $cancha->nombre,
                'direccion'  => $cancha->direccion ?? '',
                'capacidad'  => $cancha->capacidad ?? '',
                'telefono'   => $cancha->telefono ?? '',
                'condiciones'=> $cancha->condiciones ?? '',
                'id_localidad'     => $cancha->id_localidad ?? null,
                'localidad_nombre' => $localidadNombre,
            ]
        ]);
    }

    /**
     * API: Alta rápida de cancha (desde el modal)
     */
    public function canchaFast(Request $request)
    {
        $request->validate([
            'nombre'     => 'required|string|max:255',
            'localidad'  => 'required|integer|exists:localidades,id_localidad',
            'direccion'  => 'required|string|max:255',
            'capacidad'  => 'nullable|integer|min:0',
            'telefono'   => 'nullable|string|max:20',
            'condiciones'=> 'nullable|string|max:255',
        ]);

        $colLocalidad = Schema::hasColumn('canchas','localidad') ? 'localidad' :
            (Schema::hasColumn('canchas','id_localidad') ? 'id_localidad' : null);
        $colDireccion = Schema::hasColumn('canchas','direccion') ? 'direccion' :
            (Schema::hasColumn('canchas','ubicacion') ? 'ubicacion' : null);

        $insert = ['nombre' => $request->nombre];

        if ($colLocalidad) $insert[$colLocalidad] = $request->localidad;
        if ($colDireccion) $insert[$colDireccion] = $request->direccion;
        if (Schema::hasColumn('canchas','capacidad'))   $insert['capacidad']   = $request->capacidad;
        if (Schema::hasColumn('canchas','telefono'))    $insert['telefono']    = $request->telefono;
        if (Schema::hasColumn('canchas','condiciones')) $insert['condiciones'] = $request->condiciones;

        $id = DB::table('canchas')->insertGetId($insert);

        return response()->json([
            'ok'    => true,
            'cancha'=> [
                'id'   => $id,
                'text' => $request->nombre
            ]
        ]);
    }

    /**
     * API: árbitros disponibles
     */
    public function arbitrosDisponibles(Request $request)
    {
        // Aquí solo devolvemos la lista, pero ya con nombres completos reales
        $rows = DB::table('arbitros')
            ->join('personas', 'personas.id_persona', '=', 'arbitros.persona')
            ->orderBy('personas.nombre','asc')
            ->orderBy('personas.apaterno','asc')
            ->get([
                'arbitros.id_arbitro',
                DB::raw("CONCAT(personas.nombre,' ',personas.apaterno,' ',personas.amaterno) AS nombre")
            ]);

        $list = [];
        foreach ($rows as $r) {
            $list[] = [
                'id'   => $r->id_arbitro,
                'text' => $r->nombre,
            ];
        }

        return response()->json(['ok' => true, 'arbitros' => $list]);
    }
}
