<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ═══════════════════════════════════════════════
//  RUTA RAÍZ
// ═══════════════════════════════════════════════

// Al entrar a "/" redirige según si hay sesión activa o no
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('front.home');
    }
    return redirect()->route('login');
});

// Alias /dashboard para que funcione el link de la vista welcome de Laravel
Route::get('/dashboard', function () {
    return redirect()->route('front.home');
})->middleware('auth')->name('dashboard');

// ═══════════════════════════════════════════════
//  FRONT — área del jugador  (/casino/...)
// ═══════════════════════════════════════════════

Route::middleware(['auth'])->prefix('casino')->name('front.')->group(function () {
    Route::get('/',          [FrontController::class, 'home'])       ->name('home');
    Route::get('/partidos',  [FrontController::class, 'matches'])    ->name('matches');
    Route::get('/minas',     [FrontController::class, 'mines'])      ->name('mines');
    Route::get('/desafios',  [FrontController::class, 'challenges']) ->name('challenges');
    Route::get('/apuestas',  [FrontController::class, 'mybets'])     ->name('mybets');
    Route::get('/perfil',    [FrontController::class, 'profile'])    ->name('profile');
});

// ═══════════════════════════════════════════════
//  ADMIN — panel de gestión  (/admin/...)
// ═══════════════════════════════════════════════

Route::middleware(['auth'])->prefix('admin')->name('dash.')->group(function () {
    Route::get('/',              [DashboardController::class, 'index'])        ->name('index');
    Route::get('/usuarios',      [DashboardController::class, 'users'])        ->name('users');
    Route::get('/apuestas',      [DashboardController::class, 'bets'])         ->name('bets');
    Route::get('/partidos',      [DashboardController::class, 'matches'])      ->name('matches');
    Route::get('/minas',         [DashboardController::class, 'mines'])        ->name('mines');
    Route::get('/desafios',      [DashboardController::class, 'challenges'])   ->name('challenges');
    Route::get('/transacciones', [DashboardController::class, 'transactions']) ->name('transactions');
});