<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\TransaccionController;
use Illuminate\Support\Facades\Route;

// ── Solo para quien NO tiene sesión (registro y login) ────────────
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
    Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.store');
    Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');

    // Semana 12 · Reto: máximo 5 intentos por minuto (fuerza bruta)
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.attempt');
});

// ── Solo para quien SÍ tiene sesión ───────────────────────────────
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return redirect()->route('comercios.index');
    });

    Route::get('/comercios', [ComercioController::class, 'index'])
        ->name('comercios.index');

    Route::get('/comercios/{comercio}', [ComercioController::class, 'show'])
        ->name('comercios.show');

    // ── Laboratorio 1: sandbox de formulario ──────────────────────
    Route::get('/practica/formulario-demo', function () {
        return view('practica.formulario_demo');
    });

    // ── Laboratorio 4: ruta POST de prueba (CSRF) ─────────────────
    Route::post('/practica/enviar', function () {
        return 'Formulario recibido correctamente.';
    });

    // ── Semana 9 (viernes): formulario Nueva Transacción ──────────
    Route::get('/comercios/{comercio}/transacciones/nueva',
        [TransaccionController::class, 'create']
    )->name('transacciones.create');

    Route::post('/transacciones',
        [TransaccionController::class, 'store']
    )->name('transacciones.store');

    // ── Semana 11 (jueves): editar y eliminar ─────────────────────
    Route::get('/transacciones/{transaccion}/editar',
        [TransaccionController::class, 'edit']
    )->name('transacciones.edit');

    Route::put('/transacciones/{transaccion}',
        [TransaccionController::class, 'update']
    )->name('transacciones.update');

    Route::delete('/transacciones/{transaccion}',
        [TransaccionController::class, 'destroy']
    )->name('transacciones.destroy');

    // ── Semana 11 (viernes): mover estado ─────────────────────────
    Route::patch('/transacciones/{transaccion}/mover/{estado}',
        [TransaccionController::class, 'moverEstado']
    )->name('transacciones.mover');
});
