<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\DetalleBitacoraController;
use App\Http\Controllers\PuestoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login'); // más adelante crearás login.blade.php
})->name('login');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



// Ruta para la Bitácora

//Bitacora
Route::get('/bitacoras/inicio/{id}', [BitacoraController::class, 'inicio'])->name('bitacora.inicio');
Route::get('/bitacoras/rinicio', [BitacoraController::class, 'rinicio'])->name('bitacora.rinicio');
Route::get('/bitacoras/PDF', [BitacoraController::class, 'generarBitacoraPDF'])->name('generarBitacoraPDF');
Route::get('/bitacoras/PDF/{id}', [BitacoraController::class, 'generarBitacoraPDF_usuario'])->name('generarBitacoraPDF_usuario');

//DetalleBitacora
Route::get('/detbitacoras/inicio/{id}', [DetalleBitacoraController::class, 'inicio'])->name('detbitacoras.inicio');
Route::get('/detbitacoras/PDF/{id}', [DetalleBitacoraController::class, 'generarDetalleBitacoraPDF'])->name('generarDetalleBitacoraPDF');


Route::get('/puestos', [PuestoController::class, 'index'])->name('puestos');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
