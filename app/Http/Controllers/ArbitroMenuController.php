<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArbitroMenuController extends Controller
{
    /**
     * Muestra el menú del árbitro (menu_arbitro.blade.php)
     */
    public function menu(Request $r)
    {
        // Tomamos el id_persona de la sesión, igual que en el resto del sistema
        $idPersona = $r->session()->get('user_id');

        $nombreUsuario = null;

        if ($idPersona) {
            // Buscamos en personas el nombre completo
            $persona = DB::table('personas')
                ->where('id_persona', $idPersona)
                ->first(['nombre', 'apaterno', 'amaterno']);

            if ($persona) {
                $nombreUsuario = trim(
                    ($persona->nombre   ?? '') . ' ' .
                    ($persona->apaterno ?? '') . ' ' .
                    ($persona->amaterno ?? '')
                );
                if ($nombreUsuario === '') {
                    $nombreUsuario = null;
                }
            }
        }

        // Enviamos el nombre (o null) a la vista
        return view('menu_arbitro', compact('nombreUsuario'));
    }

    /**
     * Resolver id_arbitro a partir de la sesión.
     * - En tu sesión guardas: user_id = id_persona, user_rol = 'Arbitro'
     */
    private function resolveArbitroId(Request $r): ?int
    {
        // persona de la sesión
        $idPersona = $r->session()->get('user_id');

        if ($idPersona) {
            $idArb = DB::table('arbitros')
                ->where('persona', $idPersona)
                ->value('id_arbitro');

            if ($idArb) {
                return (int) $idArb;
            }
        }

        // fallback para pruebas: ?arbitro_id=1
        return (int) $r->query('arbitro_id', 1);
    }

    /**
     * GET /arbitro/stats
     * devuelve { ok, asignados, arbitrados }
     *
     * - asignados: partidos activos asignados al árbitro (sin importar fecha)
     * - arbitrados: partidos que ya tienen registro en asigna_partido
     */
    public function stats(Request $r)
    {
        $idArb = $this->resolveArbitroId($r);
        if (!$idArb) {
            return response()->json(['ok' => false, 'message' => 'Árbitro no encontrado'], 404);
        }

        // Total de partidos asignados al árbitro (activos)
        $asignados = DB::table('partido')
            ->where('id_arbitro', $idArb)
            ->where('estado_partido', 'Activo')
            ->count();

        // Partidos que ya tienen resultado (existe registro en asigna_partido)
        $arbitrados = DB::table('partido as p')
            ->join('asigna_partido as ap', 'ap.id_partido', '=', 'p.id_partido')
            ->where('p.id_arbitro', $idArb)
            ->count();

        return response()->json([
            'ok'         => true,
            'asignados'  => $asignados,
            'arbitrados' => $arbitrados,
        ]);
    }

    /**
     * GET /arbitro/partidos/proximos
     * SOLO partidos:
     *  - asignados al árbitro
     *  - fecha >= hoy (por jugarse)
     *  - estado_partido = 'Activo'
     *  - SIN resultado en asigna_partido
     */
    public function proximos(Request $r)
    {
        $idArb = $this->resolveArbitroId($r);
        if (!$idArb) {
            return response()->json(['ok' => false, 'data' => []]);
        }

        $hoy = Carbon::today()->toDateString();

        $rows = DB::table('partido as p')
            ->leftJoin('equipos as el', 'el.id_equipo', '=', 'p.equipo_local')
            ->leftJoin('equipos as ev', 'ev.id_equipo', '=', 'p.equipo_visitante')
            ->leftJoin('torneos as t', 't.id_torneo', '=', 'p.id_torneo')
            ->leftJoin('canchas as c', 'c.id_cancha', '=', 'p.id_cancha')
            ->leftJoin('asigna_partido as ap', 'ap.id_partido', '=', 'p.id_partido') // para filtrar sin resultado
            ->select(
                'p.id_partido as id',
                'p.fecha',
                'p.hora',
                't.nombre as torneo',
                'c.nombre as cancha',
                'el.nombre as local',
                'ev.nombre as visitante'
            )
            ->where('p.id_arbitro', $idArb)
            ->whereDate('p.fecha', '>=', $hoy)
            ->where('p.estado_partido', 'Activo')
            ->whereNull('ap.id_asigna') // SIN resultado todavía
            ->orderBy('p.fecha')
            ->orderBy('p.hora')
            ->get();

        return response()->json(['ok' => true, 'data' => $rows]);
    }

    /**
     * GET /arbitro/partidos/historico
     * Historial (partidos que ya tienen registro en asigna_partido).
     */
    public function historico(Request $r)
    {
        $idArb = $this->resolveArbitroId($r);
        if (!$idArb) {
            return response()->json(['ok' => false, 'data' => []]);
        }

        $rows = DB::table('partido as p')
            ->join('asigna_partido as ap', 'ap.id_partido', '=', 'p.id_partido')
            ->leftJoin('equipos as el', 'el.id_equipo', '=', 'p.equipo_local')
            ->leftJoin('equipos as ev', 'ev.id_equipo', '=', 'p.equipo_visitante')
            ->leftJoin('torneos as t', 't.id_torneo', '=', 'p.id_torneo')
            ->select(
                'p.id_partido as id',
                'p.fecha',
                'p.hora',
                't.nombre as torneo',
                'el.nombre as local',
                'ev.nombre as visitante',
                'ap.goles_local',
                'ap.goles_visitante'
            )
            ->where('p.id_arbitro', $idArb)
            ->orderByDesc('p.fecha')
            ->orderByDesc('p.id_partido')
            ->limit(30)
            ->get();

        return response()->json(['ok' => true, 'data' => $rows]);
    }

    /**
     * GET /arbitro/partidos/jugados-sin-resultado
     */
    public function partidosJugadosSinResultado(Request $r)
    {
        $idArb = $this->resolveArbitroId($r);
        if (!$idArb) {
            return response()->json(['ok' => false, 'data' => []]);
        }

        $hoy = Carbon::today()->toDateString();

        $rows = DB::table('partido as p')
            ->leftJoin('equipos as el', 'el.id_equipo', '=', 'p.equipo_local')
            ->leftJoin('equipos as ev', 'ev.id_equipo', '=', 'p.equipo_visitante')
            ->leftJoin('torneos as t', 't.id_torneo', '=', 'p.id_torneo')
            ->leftJoin('asigna_partido as ap', 'ap.id_partido', '=', 'p.id_partido')
            ->select(
                'p.id_partido as id',
                'p.fecha',
                'p.hora',
                't.nombre as torneo',
                'el.nombre as local',
                'ev.nombre as visitante'
            )
            ->where('p.id_arbitro', $idArb)
            ->whereDate('p.fecha', '<=', $hoy)
            ->where('p.estado_partido', 'Activo')
            ->whereNull('ap.id_asigna') // sin resultado
            ->orderBy('p.fecha')
            ->orderBy('p.hora')
            ->get();

        return response()->json(['ok' => true, 'data' => $rows]);
    }

    /**
     * POST /arbitro/partidos/{id}/resultado
     */
    public function guardarResultado(Request $r, int $id)
    {
        $r->validate([
            'goles_local'         => ['required', 'integer', 'min:0', 'max:99'],
            'goles_visitante'     => ['required', 'integer', 'min:0', 'max:99'],
            'amarillas_local'     => ['nullable', 'integer', 'min:0', 'max:99'],
            'amarillas_visitante' => ['nullable', 'integer', 'min:0', 'max:99'],
            'rojas_local'         => ['nullable', 'integer', 'min:0', 'max:99'],
            'rojas_visitante'     => ['nullable', 'integer', 'min:0', 'max:99'],
            'incidentes'          => ['nullable', 'string', 'max:2000'],
        ]);

        $part = DB::table('partido')->where('id_partido', $id)->first();
        if (!$part) {
            return response()->json(['ok' => false, 'message' => 'Partido no encontrado'], 404);
        }

        $idArb = $this->resolveArbitroId($r);
        if ($part->id_arbitro != $idArb) {
            return response()->json(['ok' => false, 'message' => 'No puedes registrar resultado de este partido'], 403);
        }

        $existe = DB::table('asigna_partido')->where('id_partido', $id)->first();
        if ($existe) {
            return response()->json(['ok' => false, 'message' => 'El partido ya tiene resultado registrado'], 422);
        }

        DB::table('asigna_partido')->insert([
            'id_partido'       => $id,
            'goles_local'      => (int) $r->goles_local,
            'goles_visitante'  => (int) $r->goles_visitante,
            'puntos_local'     => 0,
            'puntos_visitante' => 0,
        ]);

        return response()->json(['ok' => true]);
    }
}
