<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Equipo;
use App\Models\Torneo;
use App\Models\Partido;
use App\Models\Persona;

class MenuCoordinadorController extends Controller
{
    public function index(Request $request)
    {
        // Datos del coordinador desde la sesión
        $coordNombre = null;
        $coordCorreo = null;

        $idPersona = $request->session()->get('user_id');

        if ($idPersona) {
            $persona = Persona::where('id_persona', $idPersona)->first();
            if ($persona) {
                $coordNombre = trim($persona->nombre.' '.$persona->apaterno.' '.$persona->amaterno);
                $coordCorreo = $persona->correo ?? null;
            }
        }

        // Estadísticas reales
        $totalEquipos        = Equipo::count();
        $totalArbitros       = DB::table('arbitros')->count();
        $torneosActivos      = Torneo::count(); // si luego agregas columna estado, aquí filtras
        $partidosProgramados = Partido::whereDate('fecha', '>=', now()->toDateString())->count();

        return view('menu_cordinador', compact(
            'coordNombre',
            'coordCorreo',
            'totalEquipos',
            'totalArbitros',
            'torneosActivos',
            'partidosProgramados'
        ));
    }
}
