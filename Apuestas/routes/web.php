<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;

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

// /casino y /casino/home apuntan al mismo lugar
Route::get('/casino',      [FrontController::class, 'home'])->middleware('auth')->name('casino.home');
Route::get('/casino/home', [FrontController::class, 'home'])->middleware('auth');

// ══════════════════════════════════════════════
//  ADMIN — protegido auth + admin
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
// AGREGAR ESTA LÍNEA:
Route::get('/casino/home', [FrontController::class, 'home'])
    ->middleware('auth')
    ->name('front.home');

Route::get('/casino',      [FrontController::class, 'home'])->middleware('auth')->name('casino.home');
Route::get('/casino/home', [FrontController::class, 'home'])->middleware('auth');