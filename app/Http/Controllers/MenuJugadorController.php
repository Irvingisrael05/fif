<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MenuJugadorController extends Controller
{
    /**
     * Resuelve el id_equipo del jugador autenticado.
     * En sesión guardas: user_id = id_persona, user_rol = 'Jugador'
     */
    private function resolveEquipoId(Request $r): ?int
    {
        $idPersona = $r->session()->get('user_id');
        if (!$idPersona) {
            return null;
        }

        // AJUSTA el nombre de la tabla/columnas si en tu BD son diferentes
        $row = DB::table('jugadores')
            ->where('persona', $idPersona)
            ->first();

        if (!$row) {
            return null;
        }

        // intento dos nombres posibles de columna
        $idEquipo = $row->equipo ?? ($row->id_equipo ?? null);

        return $idEquipo ? (int) $idEquipo : null;
    }

    public function index(Request $r)
    {
        $idEquipo = $this->resolveEquipoId($r);

        // Valores por defecto si algo falla
        $equipoNombre = null;
        $stats = [
            'jugados'      => 0,
            'goles_favor'  => 0,
            'goles_contra' => 0,
            'diferencia'   => 0,
            'posicion'     => null,
        ];
        $proximos  = collect();
        $recientes = collect();

        if ($idEquipo) {
            $equipoNombre = DB::table('equipos')
                ->where('id_equipo', $idEquipo)
                ->value('nombre');

            $hoy = Carbon::today()->toDateString();

            /*
             * PRÓXIMOS PARTIDOS DEL EQUIPO
             * - estado_partido = 'Activo'
             * - fecha >= hoy
             */
            $proximos = DB::table('partido as p')
                ->leftJoin('equipos as el', 'el.id_equipo', '=', 'p.equipo_local')
                ->leftJoin('equipos as ev', 'ev.id_equipo', '=', 'p.equipo_visitante')
                ->leftJoin('torneos as t', 't.id_torneo', '=', 'p.id_torneo')
                ->leftJoin('canchas as c', 'c.id_cancha', '=', 'p.id_cancha')
                ->select(
                    'p.id_partido',
                    'p.fecha',
                    'p.hora',
                    'p.equipo_local',
                    'p.equipo_visitante',
                    't.nombre as torneo',
                    'c.nombre as cancha',
                    'c.direccion',
                    'el.nombre as local',
                    'ev.nombre as visitante'
                )
                ->where(function ($q) use ($idEquipo) {
                    $q->where('p.equipo_local', $idEquipo)
                        ->orWhere('p.equipo_visitante', $idEquipo);
                })
                ->where('p.estado_partido', 'Activo')
                ->whereDate('p.fecha', '>=', $hoy)
                ->orderBy('p.fecha')
                ->orderBy('p.hora')
                ->get();

            /*
             * PARTIDOS RECIENTES (ya tienen resultado)
             */
            $recientes = DB::table('partido as p')
                ->join('asigna_partido as ap', 'ap.id_partido', '=', 'p.id_partido')
                ->leftJoin('equipos as el', 'el.id_equipo', '=', 'p.equipo_local')
                ->leftJoin('equipos as ev', 'ev.id_equipo', '=', 'p.equipo_visitante')
                ->leftJoin('canchas as c', 'c.id_cancha', '=', 'p.id_cancha')
                ->select(
                    'p.fecha',
                    'p.hora',
                    'el.nombre as local',
                    'ev.nombre as visitante',
                    'ap.goles_local',
                    'ap.goles_visitante',
                    'c.nombre as cancha'
                )
                ->where(function ($q) use ($idEquipo) {
                    $q->where('p.equipo_local', $idEquipo)
                        ->orWhere('p.equipo_visitante', $idEquipo);
                })
                ->orderByDesc('p.fecha')
                ->orderByDesc('p.id_partido')
                ->limit(20)
                ->get();

            /*
             * STATS DEL EQUIPO: jugados, goles a favor / en contra
             */
            $jugados = $recientes->count();

            $goles = DB::table('partido as p')
                ->join('asigna_partido as ap', 'ap.id_partido', '=', 'p.id_partido')
                ->where(function ($q) use ($idEquipo) {
                    $q->where('p.equipo_local', $idEquipo)
                        ->orWhere('p.equipo_visitante', $idEquipo);
                })
                ->selectRaw('
                    SUM(
                        CASE
                            WHEN p.equipo_local = ? THEN ap.goles_local
                            ELSE ap.goles_visitante
                        END
                    ) as gf,
                    SUM(
                        CASE
                            WHEN p.equipo_local = ? THEN ap.goles_visitante
                            ELSE ap.goles_local
                        END
                    ) as gc
                ', [$idEquipo, $idEquipo])
                ->first();

            $gf = (int) ($goles->gf ?? 0);
            $gc = (int) ($goles->gc ?? 0);
            $dg = $gf - $gc;

            /*
             * POSICIÓN EN LA TABLA
             * Usamos tabla "clasificacion" (ajusta el nombre si tu vista se llama distinto)
             */
            $posicion = null;
            if (DB::getSchemaBuilder()->hasTable('clasificacion')) {
                $clas = DB::table('clasificacion')
                    ->orderByDesc('puntos')
                    ->orderByDesc('diferencia_goles')
                    ->orderByDesc('goles_favor')
                    ->get();

                foreach ($clas as $idx => $fila) {
                    $filaEquipoId = $fila->id_equipo ?? ($fila->equipo ?? null);
                    if ($filaEquipoId == $idEquipo) {
                        $posicion = $idx + 1;
                        break;
                    }
                }
            }

            $stats = [
                'jugados'      => $jugados,
                'goles_favor'  => $gf,
                'goles_contra' => $gc,
                'diferencia'   => $dg,
                'posicion'     => $posicion,
            ];
        }

        return view('menu_jugador', [
            'equipoNombre' => $equipoNombre,
            'stats'        => $stats,
            'proximos'     => $proximos,
            'recientes'    => $recientes,
            'equipoId'     => $idEquipo,
        ]);
    }
}
