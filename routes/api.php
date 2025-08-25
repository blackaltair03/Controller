<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrazaleteController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EstatusController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\ZonaController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas de la API para tu aplicación.
|
*/

// ----------------------------
// Rutas Públicas (sin autenticación)
// ----------------------------
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/brazaletes/validar', [BrazaleteController::class, 'validar']);

// ----------------------------
// Rutas Protegidas (requieren autenticación Sanctum)
// ----------------------------
Route::middleware('auth:sanctum')->group(function () {
    // Autenticación
    Route::post('/logout', [AuthController::class, 'logout']);
    
    
    // Estandarizacion de las rutas de cada uno de los recursos 
    //Creacion en automatico de las rutas index, store, show, update, destroy
    Route::apiResource('brazaletes', BrazaleteController::class)->except(['update']); // Excluimos update si no se usa
    Route::apiResource('eventos', EventoController::class);
    Route::apiResource('estatus', EstatusController::class);
    Route::apiResource('servicios', ServicioController::class);
    Route::apiResource('ubicaciones', UbicacionController::class);
    Route::apiResource('zonas', ZonaController::class);
});