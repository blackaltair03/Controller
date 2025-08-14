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

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas de la API para tu aplicación.
|
*/

// --- Rutas Públicas ---
// No requieren token de autenticación.
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('brazaletes/validar', [BrazaleteController::class, 'validar']);


// --- Rutas Protegidas ---
// Todas las rutas dentro de este grupo requieren un token válido de Sanctum.
Route::middleware('auth:sanctum')->group(function () {
    
    // Ruta para cerrar sesión (requiere estar autenticado).
    #Route::post('/logout', [AuthController::class, 'logout']);
    
    // Rutas de Brazaletes (requieren autenticación para crear y listar).
    Route::prefix('brazaletes')->group(function () {
        Route::get('/', [BrazaleteController::class, 'index']);
        Route::post('/crear', [BrazaleteController::class, 'store']);
    });

    // Rutas de Recursos para los otros controladores.
    #`apiResource` crea automáticamente las rutas para:
    // index, store, show, update, destroy.
    Route::apiResource('eventos', EventoController::class);
    Route::apiResource('estatus', EstatusController::class);
    Route::apiResource('servicios', ServicioController::class);
    Route::apiResource('ubicaciones', UbicacionController::class);
    Route::apiResource('zonas', ZonaController::class);
});