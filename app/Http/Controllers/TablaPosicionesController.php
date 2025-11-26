<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TablaPosicionesController extends Controller
{
    /**
     * Vista principal de tabla de posiciones.
     * Soporta filtro por torneo con ?torneo=ID
     */
    public function index(Request $request)
    {
        // Lista de torneos para el <select>
        $torneos = DB::table('torneos')
            ->orderBy('fecha_inicio', 'desc')
            ->get(['id_torneo', 'nombre', 'temporada']);

        // Torneo seleccionado (GET ?torneo=), si no viene tomamos el primero
        $torneoSeleccionado = $request->query('torneo');
        if (!$torneoSeleccionado && $torneos->count() > 0) {
            $torneoSeleccionado = $torneos->first()->id_torneo;
        }

        // Clasificación filtrada por torneo
        $clasificacion = collect();
        if ($torneoSeleccionado) {
            $clasificacion = DB::table('clasificacion as c')
                ->join('equipos as e', 'e.id_equipo', '=', 'c.id_equipo')
                ->join('torneos as t', 't.id_torneo', '=', 'c.id_torneo')
                ->select(
                    'c.id_torneo',
                    't.nombre as torneo',
                    'e.nombre as equipo',
                    // OJO: aquí usamos el nombre real de la columna
                    'c.partidos_jugados as pj',
                    'c.goles_favor as gf',
                    'c.goles_contra as gc',
                    'c.diferencia_goles as dg',
                    'c.puntos'
                )
                ->where('c.id_torneo', $torneoSeleccionado)
                ->orderByDesc('c.puntos')
                ->orderByDesc('c.diferencia_goles')
                ->orderByDesc('c.goles_favor')
                ->get();
        }

        return view('tabla_pocisiones', [
            'torneos'            => $torneos,
            'torneoSeleccionado' => $torneoSeleccionado,
            'clasificacion'      => $clasificacion,
        ]);
    }

    /**
     * API opcional para cargar la tabla por AJAX, si lo quieres usar.
     * GET /tabla_pocisiones/data/{id}
     */
    public function porTorneo($id)
    {
        $rows = DB::table('clasificacion as c')
            ->join('equipos as e', 'e.id_equipo', '=', 'c.id_equipo')
            ->select(
                'e.nombre as equipo',
                'c.partidos_jugados as pj',
                'c.goles_favor as gf',
                'c.goles_contra as gc',
                'c.diferencia_goles as dg',
                'c.puntos'
            )
            ->where('c.id_torneo', $id)
            ->orderByDesc('c.puntos')
            ->orderByDesc('c.diferencia_goles')
            ->orderByDesc('c.goles_favor')
            ->get();

        return response()->json([
            'ok'   => true,
            'data' => $rows,
        ]);
    }
}
