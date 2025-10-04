<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Central Domain)
|--------------------------------------------------------------------------
|
| Estas son las rutas del dominio central. Solo deben estar aquí las rutas
| necesarias para la gestión de tenants y páginas públicas centrales.
|
*/

// Página principal del dominio central
/*
Route::get('/', function () {
    return view('welcome'); // Página de bienvenida o landing page principal
});
*/
/*
Route::get('/', function () {
    return  'VISTA PRINCIPAL DEL SISTEMA SAAS'; // Página de bienvenida o landing page principal
});
*/

Route::get('/', function () {
    return view('saas.welcome');
});
Route::get('/registro-empresa', function () {
    return view('saas.registro-empresa');
});
Route::get('/precios', function () {
    return view('saas.precios');
});

Route::get('/debug', function () {
    return [
        'tenant' => tenant(),
        'current_domain' => request()->getHost(),
        'all_domains' => config('tenancy.central_domains'),
    ];
});
// Rutas públicas informativas (opcional)
Route::get('/about', function () {
    return view('about'); // Página "Acerca de"
})->name('about');

Route::get('/pricing', function () {
    return view('pricing'); // Planes y precios
})->name('pricing');

Route::get('/contact', function () {
    return view('contact'); // Contacto
})->name('contact');

// Si tienes un panel de administración central para gestionar tenants
// Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
//     Route::get('/tenants', [TenantController::class, 'index'])->name('admin.tenants.index');
//     Route::get('/tenants/create', [TenantController::class, 'create'])->name('admin.tenants.create');
//     Route::post('/tenants', [TenantController::class, 'store'])->name('admin.tenants.store');
//     Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('admin.tenants.destroy');
// });

// Autenticación del dominio central (si necesitas login de administradores centrales)
// require __DIR__ . '/auth.php';

//require __DIR__ . '/tenant.php';
