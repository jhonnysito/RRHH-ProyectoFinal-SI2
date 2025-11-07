<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\DetalleBitacoraController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\Puesto_DisponibleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ContratoController;
<<<<<<< HEAD
use App\Http\Controllers\PermisoController;
=======

use App\Http\Controllers\ConversacionController;
use App\Http\Controllers\MensajeController;
>>>>>>> origin/chatrrhhcorrejido2
use App\Http\Controllers\PostulanteController;
use App\Http\Controllers\SolicitudEmpleoController;

use App\Http\Controllers\Api\LocationRecordController;
use App\Http\Controllers\LocationRecordController as WebLocationRecordController;

use App\Http\Controllers\TenantCustomizationController;

use App\Http\Controllers\HorarioController;
use App\Http\Controllers\AsistenciaController;






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


    // Empleados
    Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');
    //Route::get('/empleados/editar/{id}', [EmpleadoController::class, 'edit'])->name('empleados.editar');
    //Route::get('/empleados/eliminar/{id}', [EmpleadoController::class, 'edit'])->name('empleados.eliminar');

    Route::get('/empleados/crear', [EmpleadoController::class, 'create'])->name('empleados.create');
    Route::post('/empleados/guardar', [EmpleadoController::class, 'store'])->name('empleados.guardar');

    Route::get('/empleados/info/{id}', [EmpleadoController::class, 'info'])
        ->name('empleados.info');

    // Vista para crear contrato de un empleado específico
    Route::get('/empleados/{empleado}/contrato', [ContratoController::class, 'create'])
        ->name('empleados.contrato.create');
    Route::prefix('contratos')->group(function () {
    Route::get('/crear/{empleado_id}', [ContratoController::class, 'create'])->name('contratos.crear');
    Route::post('/store', [ContratoController::class, 'store'])->name('contratos.store');
    Route::get('/ver/{empleado_id}', [ContratoController::class, 'ver'])->name('contratos.ver');
    Route::get('/empleados/{id}/editar', [EmpleadoController::class, 'editar'])
     ->name('empleados.editar');
     Route::get('/empleados/{id}/eliminar', [EmpleadoController::class, 'eliminar'])
     ->name('empleados.eliminar');
});
    // Rutas para Horarios de Empleados
    Route::resource('horarios', HorarioController::class)->middleware('auth');
    // Rutas para Asistencias de Empleados
    Route::resource('asistencias', AsistenciaController::class)->middleware('auth');

    //Bitacora
    Route::get('/bitacoras/inicio/{id}', [BitacoraController::class, 'inicio'])->name('bitacora.inicio');
    Route::get('/bitacoras/rinicio', [BitacoraController::class, 'rinicio'])->name('bitacora.rinicio');
    Route::get('/bitacoras/PDF', [BitacoraController::class, 'generarBitacoraPDF'])->name('generarBitacoraPDF');
    Route::get('/bitacoras/PDF/{id}', [BitacoraController::class, 'generarBitacoraPDF_usuario'])->name('generarBitacoraPDF_usuario');


    //Ruta para los roles

    //ROLES

    Route::get('/roles/inicio', [RoleController::class, 'inicio'])->name('roles.inicio');
     Route::post('/roles/actualizar', [RoleController::class, 'actualizar'])->name('roles.actualizar');
    Route::get('/roles/crear', [RoleController::class, 'crear'])->name('roles.crear');
    Route::post('/roles/guardar', [RoleController::class, 'guardar'])->name('roles.guardar');
    Route::get('/roles/editar', [RoleController::class, 'editar'])->name('roles.editar');
   
    Route::post('/roles/eliminar/{id}', [RoleController::class, 'eliminar'])->name('roles.eliminar');


    //DetalleBitacora
    Route::get('/detbitacoras/inicio/{id}', [DetalleBitacoraController::class, 'inicio'])->name('detbitacoras.inicio');
    Route::get('/detbitacoras/PDF/{id}', [DetalleBitacoraController::class, 'generarDetalleBitacoraPDF'])->name('generarDetalleBitacoraPDF');


    Route::get('/puestos', [PuestoController::class, 'index'])->name('puestos');
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


        // Ruta para ver los registros de ubicación en el dashboard
        Route::get('/location-records', [WebLocationRecordController::class, 'index'])
            ->name('asistencia.index');
    });

    // Rutas para el Chat con RRHH
    Route::middleware('auth')->group(function () {
        // Rutas para Empleados
        Route::get('/chat', [ConversacionController::class, 'index'])->name('chat.index');
        Route::get('/chat/crear', [ConversacionController::class, 'create'])->name('chat.create');
        Route::post('/chat', [ConversacionController::class, 'store'])->name('chat.store');
        Route::get('/chat/{conversacion}', [ConversacionController::class, 'show'])->name('chat.show');
        Route::post('/chat/{conversacion}/mensajes', [MensajeController::class, 'store'])->name('mensajes.store');
    });

    require __DIR__ . '/auth.php';
    Route::get('/register', function () {
        return view('auth.register'); // puedes crear más adelante esta vista
    })->name('register');
    // -----------------------------------------------------------------


    // CRUD de departamentos (sin auth)
    Route::resource('departamentos', DepartamentoController::class);
    Route::resource('cargos', CargoController::class);

    //crud de postulantes

    Route::resource('postulantes', PostulanteController::class);
    Route::resource('solicitudes', SolicitudEmpleoController::class);
    Route::post('/postulantes/{id}', [PostulanteController::class, 'guardar'])->name('postulantes.guardar');

    //puesto_disponibles
    Route::get('puesto_disponibles/inicio', [Puesto_DisponibleController::class, 'inicio'])->name('puesto_disponibles.inicio');
    Route::get('puesto_disponibles/crear', [Puesto_DisponibleController::class, 'crear'])->name('puesto_disponibles.crear');
    Route::post('puesto_disponibles/guardar', [Puesto_DisponibleController::class, 'guardar'])->name('puesto_disponibles.guardar');
    Route::get('puesto_disponibles/editar/{id}', [Puesto_DisponibleController::class, 'editar'])->name('puesto_disponibles.editar');
    Route::put('puesto_disponibles/actualizar/{id}', [Puesto_DisponibleController::class, 'actualizar'])
        ->name('puesto_disponibles.actualizar');
    Route::post('puesto_disponibles/eliminar/{id}', [Puesto_DisponibleController::class, 'eliminar'])->name('puesto_disponibles.eliminar');
    // Ver todos los puestos disponibles de la empresa
    Route::get('puesto_disponibles/empresa', [Puesto_DisponibleController::class, 'verDisponiblesEmpresa'])
        ->name('puesto_disponibles');
    // Ver detalle de un puesto disponible
    Route::get('puesto_disponible/{id}', [Puesto_DisponibleController::class, 'verDetalle'])
        ->name('puesto_disponible.ver');
    // web/tenant.php
    Route::get('puesto/{id}/postular', [Puesto_DisponibleController::class, 'postular'])
        ->name('puesto.postular');
    // Enviar formulario de postulación
    Route::post('puesto/{id}/postular', [Puesto_DisponibleController::class, 'enviarPostulacion'])
        ->name('puesto.enviarPostulacion');
    
    Route::get('puesto_disponibles/disponibles', [Puesto_DisponibleController::class, 'disponibles'])
        ->name('puesto_disponibles.disponibles');

    Route::get('puesto_disponibles/postularse/{idpuesto}', [Puesto_DisponibleController::class, 'postularse'])->name('puesto_disponibles.postularse');

    // Personalisacion
    Route::get('/customization', [TenantCustomizationController::class, 'edit'])->name('tenant.customization.edit');
    Route::put('/customization', [TenantCustomizationController::class, 'update'])->name('tenant.customization.update');
});





// Mostrar el formulario para programar entrevista
Route::get('/entrevistas/crear/{postulante}', [App\Http\Controllers\EntrevistaController::class, 'crear'])
    ->name('entrevistas.crear');
Route::get('entrevistas', [App\Http\Controllers\EntrevistaController::class, 'index'])->name('entrevistas.index');
// Guardar la entrevista en la base de datos
Route::post('/entrevistas/guardar', [App\Http\Controllers\EntrevistaController::class, 'guardar'])
    ->name('entrevistas.guardar');
// Mostrar el formulario para editar una entrevista
Route::get('/entrevistas/editar/{entrevista}', [App\Http\Controllers\EntrevistaController::class, 'editar'])
    ->name('entrevistas.edit');
    // Mostrar la evaluación de una entrevista
Route::get('/entrevistas/{entrevista}/evaluacion', [App\Http\Controllers\EntrevistaController::class, 'verEvaluacion'])
    ->name('evaluaciones.show');
    // Eliminar una entrevista
Route::delete('/entrevistas/eliminar/{entrevista}', [App\Http\Controllers\EntrevistaController::class, 'destroy'])
    ->name('entrevistas.destroy');
Route::post('/entrevistas', [App\Http\Controllers\EntrevistaController::class, 'store'])
    ->name('entrevistas.store');
    // Mostrar formulario para evaluar una entrevista
Route::get('/entrevistas/{entrevista}/evaluar', [App\Http\Controllers\EntrevistaController::class, 'evaluar'])
    ->name('entrevistas.evaluar');
    // Guardar la evaluación de la entrevista
Route::post('/entrevistas/{entrevista}/evaluar', [App\Http\Controllers\EntrevistaController::class, 'guardarEvaluacion'])
    ->name('entrevistas.guardarEvaluacion');
// Ruta de API para que la app Flutter envíe los datos de ubicación
Route::post('/api/location-records', [LocationRecordController::class, 'store'])
    ->middleware([InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class])
    ->name('api.location-records.store');



        // Para actualizar el permiso
//Route::put('/actualizar/{id}', [PermisoController::class, 'actualizar'])->name('permisos.actualizar');
Route::delete('/eliminar/{id}', [PermisoController::class, 'destroy'])->name('permisos.eliminar');
    Route::get('/editar/{id}', [PermisoController::class, 'edit'])->name('permisos.editar');


Route::middleware(['auth'])->group(function() {
    Route::resource('permisos', PermisoController::class);
});