<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Persona;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('inicio_de_secion');
    }

    public function login(Request $r)
    {
        $r->validate([
            'correo'   => ['required','email'],
            'password' => ['required','string'],
        ]);

        // buscamos por correo
        $u = Persona::where('correo', $r->correo)->first();

        // si no existe o la contraseña no coincide -> error
        if (!$u || !Hash::check($r->password, $u->password)) {
            return back()
                ->withErrors(['correo' => 'Correo y/o contraseña incorrectos'])
                ->withInput();
        }

        // guardar datos mínimos en sesión
        session([
            'user_id'    => $u->id_persona,
            'user_nombre'=> $u->nombre,
            'user_rol'   => $u->tipo_de_usuario,
        ]);

        // redirección por rol
        return match ($u->tipo_de_usuario) {
            'Coordinador' => redirect('/menu_cordinador'),
            'Arbitro'     => redirect('/menu_arbitro'),
            'Jugador'     => redirect('/menu_jugador'),
            default       => redirect('/'),
        };
    }

    public function logout()
    {
        session()->flush();
        return redirect('/inicio_de_secion')->with('ok', 'Sesión cerrada.');
    }
}
