<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JugadorGestionController extends Controller
{
    /**
     * GET /api/jugadores/pendientes
     * Jugadores con estado = 'Pendiente' (equipo NULL)
     * 🔁 Añadido: j.dorsal y j.posicion para que aparezcan en la tabla de Solicitudes.
     */
    public function pendientes()
    {
        $rows = DB::table('jugadores as j')
            ->join('personas as p','p.id_persona','=','j.persona')
            ->leftJoin('localidades as l','l.id_localidad','=','p.id_localidad')
            ->select(
                'j.id_jugador','j.persona','j.estado',
                'j.dorsal','j.posicion',             // 👈 añadidos para mostrar en la tabla
                'p.nombre','p.apaterno','p.amaterno','p.correo','p.curp','p.fecha_de_nacimiento',
                'l.comunidad as localidad'
            )
            ->where('j.estado','=','Pendiente')
            ->orderBy('j.id_jugador','desc')
            ->get();

        return response()->json(['ok'=>true,'data'=>$rows]);
    }


    /**
     * GET /api/jugadores/activos
     * Jugadores con estado = 'Activo', incluyendo nombre de equipo
     */
    public function activos()
    {
        $rows = DB::table('jugadores as j')
            ->join('personas as p','p.id_persona','=','j.persona')
            ->leftJoin('equipos as e','e.id_equipo','=','j.equipo')
            ->select(
                'j.id_jugador','j.persona','j.dorsal','j.posicion','j.estado',
                'p.nombre','p.apaterno','p.amaterno','p.correo',
                'e.id_equipo','e.nombre as equipo'
            )
            ->where('j.estado','=','Activo')
            ->orderBy('p.apaterno','asc')
            ->orderBy('p.amaterno','asc')
            ->orderBy('p.nombre','asc')
            ->get();

        return response()->json(['ok'=>true,'data'=>$rows]);
    }

    /**
     * POST /api/jugadores/{id}/aprobar
     * Asigna equipo (obligatorio). Dorsal/posicion opcionales.
     * Body: { equipo: int, dorsal?: int, posicion?: string }
     * 🔁 Cambio: si no envías dorsal/posicion, se conservan los del registro.
     * 🔁 Cambio: valido posicion contra el catálogo de tu BD.
     */
    public function aprobar(Request $r, int $id)
    {
        $r->validate([
            'equipo' => ['required','integer','exists:equipos,id_equipo'],
            // 👇 ya no validamos ni esperamos dorsal/posicion aquí
        ]);

        $jug = DB::table('jugadores')->where('id_jugador', $id)->first();
        if (!$jug) {
            return response()->json(['ok'=>false,'message'=>'Jugador no encontrado'], 404);
        }
        if ($jug->estado === 'Activo') {
            return response()->json(['ok'=>false,'message'=>'Este jugador ya está Activo'], 422);
        }

        // 👇 solo asigna equipo y cambia el estado
        DB::table('jugadores')->where('id_jugador',$id)->update([
            'equipo' => (int)$r->equipo,
            'estado' => 'Activo',
        ]);

        $row = DB::table('jugadores as j')
            ->join('personas as p','p.id_persona','=','j.persona')
            ->leftJoin('equipos as e','e.id_equipo','=','j.equipo')
            ->select(
                'j.id_jugador','j.persona','j.dorsal','j.posicion','j.estado',
                'p.nombre','p.apaterno','p.amaterno','p.correo',
                'e.id_equipo','e.nombre as equipo'
            )
            ->where('j.id_jugador',$id)
            ->first();

        return response()->json(['ok'=>true,'data'=>$row]);
    }


    /**
     * POST /api/jugadores/{id}/rechazar
     * Pone estado 'Inactivo'.
     * 👉 Si quieres conservar los valores originales para histórico, elimina
     *    las líneas que ponen NULL a dorsal/posicion.
     */
    public function rechazar(int $id)
    {
        $jug = DB::table('jugadores')->where('id_jugador', $id)->first();
        if (!$jug) {
            return response()->json(['ok'=>false,'message'=>'Jugador no encontrado'], 404);
        }

        DB::table('jugadores')->where('id_jugador',$id)->update([
            'equipo'   => null,
            'dorsal'   => null,     // quítalo si prefieres conservar
            'posicion' => null,     // quítalo si prefieres conservar
            'estado'   => 'Inactivo',
        ]);

        return response()->json(['ok'=>true]);
    }
}
