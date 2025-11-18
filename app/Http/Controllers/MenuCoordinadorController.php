<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Torneo;
use App\Models\Partido;
use App\Models\Persona;

class MenuCoordinadorController extends Controller
{
    public function index()
    {
        $totEquipos   = Equipo::count();
        $totTorneos   = Torneo::count();
        $totPartidos  = Partido::count();
        $totPersonas  = Persona::count();

        $torneosRecientes = Torneo::select('id_torneo','nombre','temporada','fecha_inicio','fecha_fin')
            ->orderBy('fecha_inicio','desc')
            ->limit(5)
            ->get();

        $proximosPartidos = Partido::with(['torneo:id_torneo,nombre','local:id_equipo,nombre','visitante:id_equipo,nombre'])
            ->whereDate('fecha','>=', now()->toDateString())
            ->orderBy('fecha','asc')
            ->orderBy('hora','asc')
            ->limit(5)
            ->get();

        return view('menu_cordinador', compact(
            'totEquipos','totTorneos','totPartidos','totPersonas',
            'torneosRecientes','proximosPartidos'
        ));
    }
}
