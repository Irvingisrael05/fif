<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EquipoController extends Controller
{
    /**
     * Pantalla principal: formulario + tabla.
     */
    public function index()
    {
        $tieneLocalidades = Schema::hasTable('localidades');
        $tieneLogos       = Schema::hasTable('logos');

        $query = DB::table('equipos as e')
            ->select(
                'e.id_equipo',
                'e.nombre',
                'e.localidad',
                'e.anio_fundacion',
                'e.colores_de_equipacion',
                'e.logo',
                'e.estado'
            );

        if ($tieneLocalidades) {
            $query->leftJoin('localidades as l', 'l.id_localidad', '=', 'e.localidad')
                ->addSelect('l.comunidad as nombre_localidad');
        }

        if ($tieneLogos) {
            $query->leftJoin('logos as lo', 'lo.id_logo', '=', 'e.logo')
                ->addSelect('lo.Url as url_logo');
        }

        $equipos = $query->orderBy('e.nombre', 'asc')->get();

        $localidades = $tieneLocalidades
            ? DB::table('localidades')
                ->orderBy('comunidad', 'asc')
                ->get(['id_localidad', 'comunidad'])
            : collect();

        return view('gestionar_equipos', compact('equipos', 'localidades'));
    }

    /**
     * Crear equipo (AJAX JSON).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'                 => 'required|string|max:100',
            'localidad'              => 'required|integer|exists:localidades,id_localidad',
            'anio_fundacion'         => 'required|integer|min:1900|max:2100',
            'colores_de_equipacion'  => 'required|string|max:100',
            'logo_url'               => 'required|url|max:255',
            'estado'                 => 'required|string|in:Activo,Inactivo',
        ], [], [
            'logo_url' => 'URL del logo'
        ]);

        // 1) Guardar logo y obtener id_logo
        $logoId = DB::table('logos')->insertGetId([
            'Url' => $request->logo_url
        ]);

        // 2) Guardar equipo
        $newId = DB::table('equipos')->insertGetId([
            'nombre'                 => $request->nombre,
            'localidad'              => $request->localidad,
            'anio_fundacion'         => $request->anio_fundacion,
            'colores_de_equipacion'  => $request->colores_de_equipacion,
            'logo'                   => $logoId,
            'estado'                 => $request->estado,
        ]);

        // 3) Devolver registro enriquecido para la tabla
        $equipo = DB::table('equipos as e')
            ->leftJoin('localidades as l', 'l.id_localidad', '=', 'e.localidad')
            ->leftJoin('logos as lo', 'lo.id_logo', '=', 'e.logo')
            ->select(
                'e.id_equipo',
                'e.nombre',
                'e.localidad',
                'e.anio_fundacion',
                'e.colores_de_equipacion',
                'e.logo',
                'e.estado',
                'l.comunidad as nombre_localidad',
                'lo.Url as url_logo'
            )
            ->where('e.id_equipo', $newId)
            ->first();

        return response()->json(['ok' => true, 'equipo' => $equipo]);
    }

    /**
     * Actualizar equipo (AJAX JSON).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'                 => 'required|string|max:100',
            'localidad'              => 'required|integer|exists:localidades,id_localidad',
            'anio_fundacion'         => 'required|integer|min:1900|max:2100',
            'colores_de_equipacion'  => 'required|string|max:100',
            'logo_url'               => 'nullable|url|max:255',
            'estado'                 => 'required|string|in:Activo,Inactivo',
        ], [], [
            'logo_url' => 'URL del logo'
        ]);

        $equipo = DB::table('equipos')->where('id_equipo', $id)->first();
        if (!$equipo) {
            return response()->json(['ok' => false, 'message' => 'Equipo no encontrado'], 404);
        }

        // Manejo del logo: actualizar o crear si viene URL
        $logoId = $equipo->logo;
        if ($request->filled('logo_url')) {
            if ($logoId) {
                DB::table('logos')->where('id_logo', $logoId)->update(['Url' => $request->logo_url]);
            } else {
                $logoId = DB::table('logos')->insertGetId(['Url' => $request->logo_url]);
            }
        }

        DB::table('equipos')->where('id_equipo', $id)->update([
            'nombre'                 => $request->nombre,
            'localidad'              => $request->localidad,
            'anio_fundacion'         => $request->anio_fundacion,
            'colores_de_equipacion'  => $request->colores_de_equipacion,
            'logo'                   => $logoId,
            'estado'                 => $request->estado,
        ]);

        $equipoActualizado = DB::table('equipos as e')
            ->leftJoin('localidades as l', 'l.id_localidad', '=', 'e.localidad')
            ->leftJoin('logos as lo', 'lo.id_logo', '=', 'e.logo')
            ->select(
                'e.id_equipo',
                'e.nombre',
                'e.localidad',
                'e.anio_fundacion',
                'e.colores_de_equipacion',
                'e.logo',
                'e.estado',
                'l.comunidad as nombre_localidad',
                'lo.Url as url_logo'
            )
            ->where('e.id_equipo', $id)
            ->first();

        return response()->json(['ok' => true, 'equipo' => $equipoActualizado]);
    }

    /**
     * Eliminar equipo (AJAX JSON).
     */
    public function destroy($id)
    {
        $equipo = DB::table('equipos')->where('id_equipo', $id)->first();
        if (!$equipo) {
            return response()->json(['ok' => false, 'message' => 'Equipo no encontrado'], 404);
        }

        // Eliminar equipo
        DB::table('equipos')->where('id_equipo', $id)->delete();

        // (Opcional) eliminar logo si ya no lo usa otro equipo
        if ($equipo->logo) {
            $usos = DB::table('equipos')->where('logo', $equipo->logo)->count();
            if ($usos === 0) {
                DB::table('logos')->where('id_logo', $equipo->logo)->delete();
            }
        }

        return response()->json(['ok' => true, 'id' => $id]);
    }

    /**
     * API simple (opcional) para selects dependientes u otros usos.
     * GET /api/equipos  -> id + nombre
     */
    public function equiposJson()
    {
        $data = DB::table('equipos')->orderBy('nombre', 'asc')->get([
            'id_equipo as id',
            'nombre'
        ]);

        return response()->json($data);
    }
}
