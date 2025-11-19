<?php

//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//   return $request->user();
//})->middleware('auth:sanctum');

use Illuminate\Http\Request;
use App\Http\Controllers\Api\LocationRecordController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PermisoEmpleadoController;





Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Credenciales inválidas'], 401);
    }

    $user = $request->user();
    $token = $user->createToken('flutter-token')->plainTextToken;

    return response()->json([
        'message' => 'Login exitoso',
        'token' => $token,
        'user' => $user,
    ]);
});

Route::middleware([
    'auth:sanctum',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    //Route::post('/permisos/enviar', [PermisoEmpleadoController::class, 'enviarSolicitud'])->name('permisos.enviar-solicitud');
    Route::post('/permisos/solicitud', [PermisoEmpleadoController::class, 'enviarSolicitudApi']);
    Route::post('/location-records', [LocationRecordController::class, 'store']);
});
