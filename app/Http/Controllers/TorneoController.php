<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Torneo;
use App\Models\Localidad;

class TorneoController extends Controller
{
    // LISTA + datos para el formulario
    public function index()
    {
        $localidades = \App\Models\Localidad::orderBy('comunidad','asc')
            ->get(['id_localidad','comunidad']);

        $estado = request('estado', 'todos'); // 'todos' por defecto

        $torneos = \App\Models\Torneo::with('localidadRel')
            ->filtrarPorEstado($estado)
            ->orderBy('fecha_inicio','desc')
            ->get();

        return view('gestionar_torneos', compact('localidades','torneos','estado'));
    }


    // CREAR
    public function store(Request $r)
    {
        $r->validate([
            'nombre'        => ['required','string','max:100'],
            'temporada'     => ['required','integer','min:2000','max:2100'],
            'fecha_inicio'  => ['required','date'],
            'fecha_fin'     => ['required','date','after:fecha_inicio'],
            'localidad'     => ['required','integer','exists:localidades,id_localidad'],
            'descripcion'   => ['required','string'],
        ]);

        Torneo::create([
            'nombre'        => $r->nombre,
            'temporada'     => $r->temporada,
            'fecha_inicio'  => $r->fecha_inicio,
            'fecha_fin'     => $r->fecha_fin,
            'localidad'     => $r->localidad,
            'descripcion'   => $r->descripcion,
        ]);

        return back()->with('ok', 'Torneo creado correctamente.');
    }

    // ACTUALIZAR (opcional si luego activas el botón Editar)
    public function update($id, Request $r)
    {
        $torneo = Torneo::findOrFail($id);

        $r->validate([
            'nombre'        => ['required','string','max:100'],
            'temporada'     => ['required','integer','min:2000','max:2100'],
            'fecha_inicio'  => ['required','date'],
            'fecha_fin'     => ['required','date','after:fecha_inicio'],
            'localidad'     => ['required','integer','exists:localidades,id_localidad'],
            'descripcion'   => ['required','string'],
        ]);

        $torneo->update([
            'nombre'        => $r->nombre,
            'temporada'     => $r->temporada,
            'fecha_inicio'  => $r->fecha_inicio,
            'fecha_fin'     => $r->fecha_fin,
            'localidad'     => $r->localidad,
            'descripcion'   => $r->descripcion,
        ]);

        return back()->with('ok', 'Torneo actualizado.');
    }

    // ELIMINAR (opcional si luego activas el botón Eliminar)
    public function destroy($id)
    {
        Torneo::where('id_torneo',$id)->delete();
        return back()->with('ok', 'Torneo eliminado.');
    }
}
