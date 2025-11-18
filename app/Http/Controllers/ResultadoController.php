<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{AsignaPartido,Partido};

class ResultadoController extends Controller
{
public function create() {
$partidos = Partido::orderBy('fecha','desc')->get();
return view('registro_resultados', compact('partidos'));
}

public function store(Request $r) {
$r->validate([
'id_partido'=>'required|integer|exists:partido,id_partido',
'goles_local'=>'required|integer|min:0',
'goles_visitante'=>'required|integer|min:0'
]);
AsignaPartido::create([
'id_partido'=>$r->id_partido,
'goles_local'=>$r->goles_local,
'goles_visitante'=>$r->goles_visitante
// puntos_* los calcula el trigger
]);
return back()->with('ok','Resultado registrado');
}
}

