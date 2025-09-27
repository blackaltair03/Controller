<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrazaleteController;
use App\Http\Controllers\Api\EventoController;
use App\Http\Controllers\Api\EstatusController;
use App\Http\Controllers\Api\ServicioController;
use App\Http\Controllers\Api\UbicacionController;
use App\Http\Controllers\Api\ZonaController;
use App\Http\Controllers\Api\VerificarBrazaleteController;

// ----------------------------
// Rutas Públicas
// ----------------------------
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/brazaletes/validar', [BrazaleteController::class, 'validar']);
Route::post('/brazaletes/verificar', VerificarBrazaleteController::class); // Para verificación por cadena

// ----------------------------
// Rutas Protegidas
// ----------------------------
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('brazaletes', BrazaleteController::class);
    Route::apiResource('eventos', EventoController::class);
    Route::apiResource('estatus', EstatusController::class);
    Route::apiResource('servicios', ServicioController::class);
    Route::apiResource('ubicaciones', UbicacionController::class);
    Route::apiResource('zonas', ZonaController::class);
});