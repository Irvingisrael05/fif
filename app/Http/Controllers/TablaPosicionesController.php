<?php

namespace App\Http\Controllers;
use App\Models\VistaTablaPosiciones;

class TablaPosicionesController extends Controller
{
public function index() {
$tabla = VistaTablaPosiciones::orderBy('puntos','desc')
->orderBy('diferencia_goles','desc')
->orderBy('goles_favor','desc')->get();
return view('tabla_pocisiones', compact('tabla'));
}
}
