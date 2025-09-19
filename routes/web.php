<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\CargoController;

/*
'name' => 'Admin',
'email' => 'admin@admin.com',
'password' => bcrypt('12345678'),
*/

// Al entrar a "/" redirige directo al index del CRUD
Route::get('/', function () {
    //return redirect()->route('departamentos.index');
    return redirect()->route('cargos.index');
});

/*
Route::get('/', function () {
    return view('welcome');
}); */

/*
Route::get('/login', function() {
    return view('auth.login'); // más adelante crearás login.blade.php

})->name('login');

Route::get('/register', function () {
    return view('auth.register'); // puedes crear más adelante esta vista
})->name('register');*/
// -----------------------------------------------------------------


// CRUD de departamentos (sin auth)
Route::resource('departamentos', DepartamentoController::class);
Route::resource('cargos', CargoController::class);

// CRUD protegido por auth
/*
Route::middleware(['auth'])->group(function () {
    Route::resource('departamentos', DepartamentoController::class);
});*/
