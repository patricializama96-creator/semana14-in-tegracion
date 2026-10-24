<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\TransaccionApiController;
use App\Http\Resources\ComercioResource;
use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Pública: aquí se obtiene el token
Route::post('/login', [AuthApiController::class, 'login'])
    ->middleware('throttle:5,1');

// Protegidas: requieren token
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/yo', [AuthApiController::class, 'yo']);
    Route::post('/logout', [AuthApiController::class, 'logout']);

    // Reto: dispositivos con sesión abierta
    Route::get('/tokens', [AuthApiController::class, 'tokens']);
    Route::delete('/tokens/{id}', [AuthApiController::class, 'borrarToken']);

    // Lab 6: cada usuario ve solo sus comercios
    Route::get('/comercios', function (Request $request) {
        return ComercioResource::collection(
            $request->user()->comercios()->orderBy('nombre_comercio')->get()
        );
    });

    Route::get('/comercios/{comercio}', function (Request $request, Comercio $comercio) {
        abort_unless($comercio->user_id === $request->user()->id, 404);
        return new ComercioResource($comercio->load('transacciones'));
    });

    // Semana 13 · Lab 6: rutas REST para transacciones (sin update: el controlador no lo tiene)
    Route::apiResource('transacciones', TransaccionApiController::class)
        ->only(['index', 'show', 'store', 'destroy'])
        ->parameters(['transacciones' => 'transaccion']);
});
