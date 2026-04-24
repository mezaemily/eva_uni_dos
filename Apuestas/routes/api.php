<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\ApuestaController;
use App\Http\Controllers\Api\TransaccionController;
use App\Http\Controllers\Api\DesafioController;
use App\Http\Controllers\Api\CuotaController;

// ══════════════════════════════════════════════
//  AUTH — públicas
// ══════════════════════════════════════════════
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// ══════════════════════════════════════════════
//  RUTAS PROTEGIDAS — JWT
// ══════════════════════════════════════════════
Route::middleware('jwt')->group(function () {

    // ── Auth ────────────────────────────────────
    Route::get('/user',     [AuthController::class, 'getUser']);
    Route::put('/user',     [AuthController::class, 'updateUser']);
    Route::post('/logout',  [AuthController::class, 'logout']);

    // ── Usuarios ────────────────────────────────
    Route::apiResource('usuarios', UsuarioController::class);

    // ── Apuestas (Comprar / Vender / Subastar) ──
    Route::get('/apuestas',              [ApuestaController::class, 'index']);
    Route::post('/apuestas',             [ApuestaController::class, 'store']);    // COMPRAR
    Route::get('/apuestas/{apuesta}',    [ApuestaController::class, 'show']);
    Route::delete('/apuestas/{apuesta}', [ApuestaController::class, 'destroy']);  // VENDER
    Route::post('/apuestas/subasta',     [ApuestaController::class, 'subasta']);  // SUBASTAR

    // ── Transacciones / Pagos ───────────────────
    Route::get('/transacciones',           [TransaccionController::class, 'index']);
    Route::get('/transacciones/saldo',     [TransaccionController::class, 'saldo']);
    Route::get('/transacciones/{id}',      [TransaccionController::class, 'show']);
    Route::post('/transacciones/deposito', [TransaccionController::class, 'deposito']);
    Route::post('/transacciones/retiro',   [TransaccionController::class, 'retiro']);

    // ── Desafíos ────────────────────────────────
    Route::apiResource('desafios', DesafioController::class);
    Route::post('/desafios/{desafio}/resolver', [DesafioController::class, 'resolver']);

    // ── Cuotas ──────────────────────────────────
    Route::apiResource('cuotas', CuotaController::class);
});