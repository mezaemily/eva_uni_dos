<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MineGameController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\DeporteController;
use App\Http\Controllers\Admin\EquipoController;
use App\Http\Controllers\Admin\PartidoController;

Route::get("/docs",function(){
 return view('docs');
});
// ══════════════════════════════════════════════
//  RAÍZ
// ══════════════════════════════════════════════
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect('/admin')
            : redirect('/casino/home');
    }
    return view('welcome');
});

// ══════════════════════════════════════════════
//  AUTH
// ══════════════════════════════════════════════
Route::middleware('guest')->group(function () {
    Route::get('/login',     [LoginController::class,    'showLogin'])    ->name('login');
    Route::post('/login',    [LoginController::class,    'login']);
    Route::get('/register',  [RegisterController::class, 'showRegister']) ->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ══════════════════════════════════════════════
//  FRONT — área del jugador
// ══════════════════════════════════════════════
Route::middleware('auth')->prefix('casino')->name('front.')->group(function () {
    Route::get('/home',     [FrontController::class, 'home'])       ->name('home');
    Route::get('/partidos', [FrontController::class, 'matches'])    ->name('matches');
    Route::get('/minas',    [FrontController::class, 'mines'])      ->name('mines');
    Route::get('/desafios', [FrontController::class, 'challenges']) ->name('challenges');
    Route::get('/apuestas', [FrontController::class, 'mybets'])     ->name('mybets');
    Route::get('/perfil',   [FrontController::class, 'profile'])    ->name('profile');
});

// Alias
Route::get('/casino/home', [FrontController::class, 'home'])->middleware('auth')->name('front.home');
Route::get('/casino',      [FrontController::class, 'home'])->middleware('auth')->name('casino.home');

// ══════════════════════════════════════════════
//  MINES — rutas AJAX
// ══════════════════════════════════════════════
Route::middleware('auth')->prefix('casino')->group(function () {
    Route::post('/minas/iniciar', [MineGameController::class, 'start'])   ->name('mines.start');
    Route::post('/minas/revelar', [MineGameController::class, 'reveal'])  ->name('mines.reveal');
    Route::post('/minas/cobrar',  [MineGameController::class, 'cashout']) ->name('mines.cashout');
    Route::get('/minas/estado',   [MineGameController::class, 'status'])  ->name('mines.status');
});

// ══════════════════════════════════════════════
//  ADMIN — vistas de solo lectura
// ══════════════════════════════════════════════
Route::middleware(['auth', 'admin'])->prefix('admin')->name('dash.')->group(function () {
    Route::get('/',              [DashboardController::class, 'index'])       ->name('index');
    Route::get('/usuarios',      [DashboardController::class, 'users'])       ->name('users');
    Route::get('/apuestas',      [DashboardController::class, 'bets'])        ->name('bets');
    Route::get('/partidos',      [DashboardController::class, 'matches'])     ->name('matches');
    Route::get('/minas',         [DashboardController::class, 'mines'])       ->name('mines');
    Route::get('/desafios',      [DashboardController::class, 'challenges'])  ->name('challenges');
    Route::get('/transacciones', [DashboardController::class, 'transactions'])->name('transactions');
});

// ══════════════════════════════════════════════
//  ADMIN — CRUDs
// ══════════════════════════════════════════════
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Usuarios
    Route::get('/crud/usuarios',                      [UsuarioController::class, 'index'])  ->name('usuarios.index');
    Route::get('/crud/usuarios/crear',                [UsuarioController::class, 'create']) ->name('usuarios.create');
    Route::post('/crud/usuarios',                     [UsuarioController::class, 'store'])  ->name('usuarios.store');
    Route::get('/crud/usuarios/{usuario}/editar',     [UsuarioController::class, 'edit'])   ->name('usuarios.edit');
    Route::put('/crud/usuarios/{usuario}',            [UsuarioController::class, 'update']) ->name('usuarios.update');
    Route::delete('/crud/usuarios/{usuario}',         [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    // Deportes
    Route::get('/crud/deportes',                      [DeporteController::class, 'index'])  ->name('deportes.index');
    Route::get('/crud/deportes/crear',                [DeporteController::class, 'create']) ->name('deportes.create');
    Route::post('/crud/deportes',                     [DeporteController::class, 'store'])  ->name('deportes.store');
    Route::get('/crud/deportes/{deporte}/editar',     [DeporteController::class, 'edit'])   ->name('deportes.edit');
    Route::put('/crud/deportes/{deporte}',            [DeporteController::class, 'update']) ->name('deportes.update');
    Route::delete('/crud/deportes/{deporte}',         [DeporteController::class, 'destroy'])->name('deportes.destroy');

    // Equipos
    Route::get('/crud/equipos',                       [EquipoController::class, 'index'])  ->name('equipos.index');
    Route::get('/crud/equipos/crear',                 [EquipoController::class, 'create']) ->name('equipos.create');
    Route::post('/crud/equipos',                      [EquipoController::class, 'store'])  ->name('equipos.store');
    Route::get('/crud/equipos/{equipo}/editar',       [EquipoController::class, 'edit'])   ->name('equipos.edit');
    Route::put('/crud/equipos/{equipo}',              [EquipoController::class, 'update']) ->name('equipos.update');
    Route::delete('/crud/equipos/{equipo}',           [EquipoController::class, 'destroy'])->name('equipos.destroy');

    // Partidos
    Route::get('/crud/partidos',                      [PartidoController::class, 'index'])  ->name('partidos.index');
    Route::get('/crud/partidos/crear',                [PartidoController::class, 'create']) ->name('partidos.create');
    Route::post('/crud/partidos',                     [PartidoController::class, 'store'])  ->name('partidos.store');
    Route::get('/crud/partidos/{partido}/editar',     [PartidoController::class, 'edit'])   ->name('partidos.edit');
    Route::put('/crud/partidos/{partido}',            [PartidoController::class, 'update']) ->name('partidos.update');
    Route::delete('/crud/partidos/{partido}',         [PartidoController::class, 'destroy'])->name('partidos.destroy');
});