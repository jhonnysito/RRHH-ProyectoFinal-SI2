<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\DetalleBitacoraController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\Puesto_DisponibleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PersonalizacionController;
use App\Http\Controllers\Api\LocationRecordController;
use App\Http\Controllers\LocationRecordController as WebLocationRecordController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/
/*
// Ruta principal
Route::get('/', function () {
    // Esta ruta es para los dominios de los tenants.
    // El middleware 'InitializeTenancyByDomain' ya se ha ejecutado.
    return 'ES TENANT: ' . tenant('id');
});
*/
// Ruta principal
Route::middleware([
    'web', //middleware web normal de laravel
    InitializeTenancyByDomain::class, // detecta y activa el tenant segun el dominio
    PreventAccessFromCentralDomains::class, // bloquea accesos desde dominios centrales


])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    /*
    Route::get('/login', function () {
        return view('auth.login'); // más adelante crearás login.blade.php

    })->name('login');
*/
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');




    // Ruta para la Bitácora

    //Bitacora
    Route::get('/bitacoras/inicio/{id}', [BitacoraController::class, 'inicio'])->name('bitacora.inicio');
    Route::get('/bitacoras/rinicio', [BitacoraController::class, 'rinicio'])->name('bitacora.rinicio');
    Route::get('/bitacoras/PDF', [BitacoraController::class, 'generarBitacoraPDF'])->name('generarBitacoraPDF');
    Route::get('/bitacoras/PDF/{id}', [BitacoraController::class, 'generarBitacoraPDF_usuario'])->name('generarBitacoraPDF_usuario');


    //Ruta para los roles

    //ROLES

    Route::get('/roles/inicio', [RoleController::class, 'inicio'])->name('roles.inicio');
    Route::get('/roles/crear', [RoleController::class, 'crear'])->name('roles.crear');
    Route::post('/roles/guardar', [RoleController::class, 'guardar'])->name('roles.guardar');
    Route::get('/roles/editar/{id}', [RoleController::class, 'editar'])->name('roles.editar');
    Route::post('/roles/actualizar/{id}', [RoleController::class, 'actualizar'])->name('roles.actualizar');
    Route::post('/roles/eliminar/{id}', [RoleController::class, 'eliminar'])->name('roles.eliminar');


    //DetalleBitacora
    Route::get('/detbitacoras/inicio/{id}', [DetalleBitacoraController::class, 'inicio'])->name('detbitacoras.inicio');
    Route::get('/detbitacoras/PDF/{id}', [DetalleBitacoraController::class, 'generarDetalleBitacoraPDF'])->name('generarDetalleBitacoraPDF');


    Route::get('/puestos', [PuestoController::class, 'index'])->name('puestos');
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Rutas para Personalización
        Route::get('/personalizacion', [PersonalizacionController::class, 'edit'])->name('personalizacion.edit');
        Route::post('/personalizacion', [PersonalizacionController::class, 'update'])->name('personalizacion.update');

        // Ruta para ver los registros de ubicación en el dashboard
        Route::get('/location-records', [WebLocationRecordController::class, 'index'])
            ->name('location-records.index');
    });

    require __DIR__ . '/auth.php';
    Route::get('/register', function () {
        return view('auth.register'); // puedes crear más adelante esta vista
    })->name('register');
    // -----------------------------------------------------------------


    // CRUD de departamentos (sin auth)
    Route::resource('departamentos', DepartamentoController::class);
    Route::resource('cargos', CargoController::class);

    //puesto_disponibles
    Route::get('puesto_disponibles/inicio', [Puesto_DisponibleController::class, 'inicio'])->name('puesto_disponibles.inicio');
    Route::get('puesto_disponibles/crear', [Puesto_DisponibleController::class, 'crear'])->name('puesto_disponibles.crear');
    Route::post('puesto_disponibles/guardar', [Puesto_DisponibleController::class, 'guardar'])->name('puesto_disponibles.guardar');
    Route::get('puesto_disponibles/editar/{id}', [Puesto_DisponibleController::class, 'editar'])->name('puesto_disponibles.editar');
    Route::post('puesto_disponibles/actualizar/{id}', [Puesto_DisponibleController::class, 'actualizar'])->name('puesto_disponibles.actualizar');
    Route::post('puesto_disponibles/eliminar/{id}', [Puesto_DisponibleController::class, 'eliminar'])->name('puesto_disponibles.eliminar');
    Route::get('puesto_disponibles/disponibles', [Puesto_DisponibleController::class, 'disponibles'])
        ->name('puesto_disponibles.disponibles');

    Route::get('puesto_disponibles/postularse/{idpuesto}', [Puesto_DisponibleController::class, 'postularse'])->name('puesto_disponibles.postularse')->middleware('auth');
});

// Ruta de API para que la app Flutter envíe los datos de ubicación
Route::post('/api/location-records', [Api\LocationRecordController::class, 'store'])
    ->middleware([InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class])
    ->name('api.location-records.store');
