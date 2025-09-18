<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BitacoraController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login'); // más adelante crearás login.blade.php
})->name('login');

Route::get('/register', function () {
    return view('auth.register'); // puedes crear más adelante esta vista
})->name('register');

// Ruta para el Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Ruta para la Bitácora
Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
