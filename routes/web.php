<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| USE: Controladores
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistroController;

use App\Http\Controllers\MenuCoordinadorController;
use App\Http\Controllers\MenuJugadorController;

use App\Http\Controllers\EquipoController;
use App\Http\Controllers\TorneoController;
use App\Http\Controllers\PartidoController;
use App\Http\Controllers\ResultadoController;
use App\Http\Controllers\TablaPosicionesController;

use App\Http\Controllers\ArbitroAsignacionesController;
use App\Http\Controllers\JugadorGestionController;
use App\Http\Controllers\ArbitroMenuController;

/*
|--------------------------------------------------------------------------
| USE: Middlewares
|--------------------------------------------------------------------------
*/
use App\Http\Middleware\AuthSession;
use App\Http\Middleware\RoleIs;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Landing
Route::view('/', 'welcome')->name('home');

// Login / Logout
Route::get ('/inicio_de_secion', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/inicio_de_secion', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout',            [AuthController::class, 'logout'])->name('logout');

// Registro
Route::get ('/registro', [RegistroController::class, 'form'])->name('registro.form');
Route::post('/registro', [RegistroController::class, 'store'])->name('registro.store');

// Tabla pública de posiciones
Route::get('/tabla_pocisiones', [TablaPosicionesController::class, 'index'])->name('posiciones.index');

// APIs públicas auxiliares
Route::get('/api/equipos', [EquipoController::class, 'equiposJson'])->name('api.equipos');

Route::get('/api/localidades', function () {
    return \App\Models\Localidad::orderBy('comunidad', 'asc')
        ->get(['id_localidad as id', 'comunidad']);
})->name('api.localidades');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS - COORDINADOR
|--------------------------------------------------------------------------
*/
Route::middleware([AuthSession::class, RoleIs::class . ':Coordinador'])->group(function () {

    // Dashboard coordinador
    Route::get('/menu_cordinador', [MenuCoordinadorController::class, 'index'])->name('menu.cordinador');

    // Equipos
    Route::get   ('/gestionar_equipos', [EquipoController::class, 'index'])->name('equipos.index');
    Route::post  ('/equipos',           [EquipoController::class, 'store'])->name('equipos.store');
    Route::put   ('/equipos/{id}',      [EquipoController::class, 'update'])->name('equipos.update');
    Route::delete('/equipos/{id}',      [EquipoController::class, 'destroy'])->name('equipos.destroy');

    // Torneos
    Route::get   ('/gestionar_torneos', [TorneoController::class, 'index'])->name('torneos.index');
    Route::post  ('/torneos',           [TorneoController::class, 'store'])->name('torneos.store');
    Route::put   ('/torneos/{id}',      [TorneoController::class, 'update'])->name('torneos.update');
    Route::delete('/torneos/{id}',      [TorneoController::class, 'destroy'])->name('torneos.destroy');

    // Partidos (programación)
    Route::get   ('/programar_partidos', [PartidoController::class, 'create'])->name('partidos.create');
    Route::post  ('/partidos',           [PartidoController::class, 'store'])->name('partidos.store');
    Route::put   ('/partidos/{id}',      [PartidoController::class, 'update'])->name('partidos.update');
    Route::delete('/partidos/{id}',      [PartidoController::class, 'destroy'])->name('partidos.destroy');

    // Resultados (pantalla clásica del coordinador)
    Route::get   ('/registro_resultados', [ResultadoController::class, 'create'])->name('resultados.create');
    Route::post  ('/resultados',          [ResultadoController::class, 'store'])->name('resultados.store');
    Route::put   ('/resultados/{id}',     [ResultadoController::class, 'update'])->name('resultados.update');
    Route::delete('/resultados/{id}',     [ResultadoController::class, 'destroy'])->name('resultados.destroy');

    // Endpoints auxiliares para partidos
    Route::get ('/partidos/canchas/{id}', [PartidoController::class, 'canchaShow'])->name('partidos.cancha.show');
    Route::post('/partidos/canchas/fast', [PartidoController::class, 'canchaFast'])->name('partidos.cancha.fast');
    Route::get ('/partidos/arbitros/disponibles', [PartidoController::class, 'arbitrosDisponibles'])
        ->name('partidos.arbitros.disponibles');

    // CRUD Árbitros
    Route::get   ('/arbitros',      [ArbitroAsignacionesController::class, 'arbitrosIndex'])->name('arbitros.index');
    Route::post  ('/arbitros',      [ArbitroAsignacionesController::class, 'arbitrosStore'])->name('arbitros.store');
    Route::put   ('/arbitros/{id}', [ArbitroAsignacionesController::class, 'arbitrosUpdate'])->name('arbitros.update');
    Route::delete('/arbitros/{id}', [ArbitroAsignacionesController::class, 'arbitrosDestroy'])->name('arbitros.destroy');

    // Jugadores
    Route::get ('/api/jugadores/pendientes', [JugadorGestionController::class, 'pendientes'])->name('jugadores.pendientes');
    Route::get ('/api/jugadores/activos',    [JugadorGestionController::class, 'activos'])->name('jugadores.activos');
    Route::post('/api/jugadores/{id}/aprobar',  [JugadorGestionController::class, 'aprobar'])->name('jugadores.aprobar');
    Route::post('/api/jugadores/{id}/rechazar', [JugadorGestionController::class, 'rechazar'])->name('jugadores.rechazar');

});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS - ÁRBITRO
|--------------------------------------------------------------------------
*/
Route::middleware([AuthSession::class, RoleIs::class . ':Arbitro'])->group(function () {

    // Menú del árbitro
    Route::get('/menu_arbitro', [ArbitroMenuController::class, 'menu'])->name('arbitro.menu');

    // APIs usadas por AJAX en menu_arbitro.blade.php
    Route::get('/arbitro/stats',                    [ArbitroMenuController::class, 'stats']);
    Route::get('/arbitro/partidos/proximos',        [ArbitroMenuController::class, 'proximos']);
    Route::get('/arbitro/partidos/historico',       [ArbitroMenuController::class, 'historico']);
    Route::post('/arbitro/partidos/{id}/resultado', [ArbitroMenuController::class, 'guardarResultado']);

    // Página independiente para registrar resultado (usa registro_resultados.blade.php)
    Route::get('/arbitro/resultados/registrar', function () {
        return view('registro_resultados');   // <-- nombre correcto del blade
    })->name('arbitro.resultados.create');

    // Endpoint JSON para partidos jugados sin resultado
    Route::get(
        '/arbitro/partidos/jugados-sin-resultado',
        [ArbitroMenuController::class, 'partidosJugadosSinResultado']
    )->name('arbitro.partidos.jugados_sin_resultado');

    // Vista clásica de "mis partidos" (si la sigues usando)
    Route::get('/mis_partidos', [ArbitroAsignacionesController::class, 'index'])->name('arbitro.partidos');
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS - JUGADOR
|--------------------------------------------------------------------------
*/
Route::middleware([AuthSession::class, RoleIs::class . ':Jugador'])->group(function () {
    Route::get('/menu_jugador', [MenuJugadorController::class, 'index'])->name('menu.jugador');
});





/*
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inicio_de_secion', function (){
    return view('inicio_de_secion');
});

Route::get('/registro', function () {
    return view('registro');
});

Route::get('/menu_arbitro', function () {
    return view('menu_arbitro');
});

Route::get('/menu_cordinador', function () {
    return view('menu_cordinador');
});

Route::get('/menu_jugador', function () {
    return view('menu_jugador');
});

Route::get('/registro_resultados', function () {
    return view('registro_resultados');
});

Route::get('/partidos_asignados_arbitros', function () {
    return view('partidos_asignados_arbitros');
});

Route::get('/tabla_pocisiones', function () {
    return view('tabla_pocisiones');
});

Route::get('/gestionar_torneos', function () {
    return view('gestionar_torneos');
});

Route::get('/programar_partidos', function () {
    return view('programar_partidos');
});

Route::get('/gestionar_equipos', function () {
    return view('gestionar_equipos');
});*/

Route::get('/pollos', function () {
    return view('pollos');
});
