<?php

namespace App\Http\Controllers;

use App\Models\PermisoEmpleado;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\PermisosNotification;
use App\Models\User; // Para buscar al administrador
use Illuminate\Support\Facades\Http;

class PermisoEmpleadoController extends Controller
{

    public function solicitud()
    {
        // Tipos de permisos disponibles
        $incidencias = ['vacaciones', 'enfermedad', 'otros'];

        return view('permisos.solicitud', compact('incidencias'));
    }

    /**
     * Procesa y guarda la solicitud de permiso.
     */


    public function enviarSolicitud(Request $request)
    {
        // VALIDACIÓN
        $request->validate([
            'incidencia' => 'required|in:enfermedad,vacaciones,otros',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'motivo' => 'nullable|string|max:255',
            'imagen' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB
        ]);

        // SUBIR ARCHIVO SI EXISTE
        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('permisos', 'public');
        }

        // CREACIÓN DEL PERMISO
        $permiso = PermisoEmpleado::create([
            'user_id' => Auth::id(),
            'incidencia' => $request->incidencia,  // <---- NUEVO CAMPO
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'motivo' => $request->motivo,
            'imagen' => $rutaImagen, // <---- NUEVA IMAGEN
            'estado' => 'solicitado',
            'tenant_id'       => tenant('id'),
        ]);

        // NOTIFICAR EMPLEADO
        $user = Auth::user();
        if ($user) {
            // $user->notify(new PermisosNotification($permiso, 'solicitado'));
        }

        // NOTIFICAR ADMINISTRADORES
        $administradores = User::role('Admin')->get();
        foreach ($administradores as $admin) {
            $admin->notify(new PermisosNotification($permiso, 'solicitado'));
        }

        return redirect()
            ->route('permisos.historial')
            ->with('creado', 'Solicitud de permiso enviada con éxito. Pendiente de aprobación.');
    }


    /**
     * Procesa y guarda la solicitud de permiso (API para Postman).
     */
    public function enviarSolicitudApi(Request $request)
    {
        try {
            // VALIDACIÓN
            $validated = $request->validate([
                'incidencia' => 'required|in:enfermedad,vacaciones,otros',
                'fecha_inicio' => 'required|date|after_or_equal:today',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'motivo' => 'nullable|string|max:255',
                'imagen' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB
            ]);

            // SUBIR ARCHIVO SI EXISTE
            $rutaImagen = null;
            if ($request->hasFile('imagen')) {
                $rutaImagen = $request->file('imagen')->store('permisos', 'public');
            }

            // CREACIÓN DEL PERMISO
            $permiso = PermisoEmpleado::create([
                'user_id' => Auth::id(),
                'incidencia' => $request->incidencia,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'motivo' => $request->motivo,
                'imagen' => $rutaImagen,
                'estado' => 'solicitado',
                'tenant_id' => tenant('id'),
            ]);

            // NOTIFICAR ADMINISTRADORES
            $administradores = User::role('Admin')->get();
            foreach ($administradores as $admin) {
                $admin->notify(new PermisosNotification($permiso, 'solicitado'));
            }

            // RESPUESTA JSON
            return response()->json([
                'success' => true,
                'message' => 'Solicitud de permiso enviada con éxito. Pendiente de aprobación.',
                'data' => [
                    'permiso' => [
                        'id' => $permiso->id,
                        'incidencia' => $permiso->incidencia,
                        'fecha_inicio' => $permiso->fecha_inicio,
                        'fecha_fin' => $permiso->fecha_fin,
                        'motivo' => $permiso->motivo,
                        'estado' => $permiso->estado,
                        'imagen' => $rutaImagen ? asset('storage/' . $rutaImagen) : null,
                        'created_at' => $permiso->created_at->format('Y-m-d H:i:s'),
                    ]
                ]
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Muestra el historial de permisos del empleado o la lista de solicitudes para el administrador.
     */
    public function historial()
    {
        if (Auth::user()->hasRole('Administrador')) {
            $permisos = PermisoEmpleado::with('user')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $permisos = PermisoEmpleado::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('permisos.historial', compact('permisos'));
    }

    /**
     * Aprueba un permiso. Solo accesible por administradores.
     */
    public function aprobar(PermisoEmpleado $permiso)
    {
        // Gate::authorize('manage-permisos');
        try {
            //$response = Http::post('http://localhost:9000/api/fcm/send/', [
            $response = Http::post('http://django:8001/api/fcm/send/', [
                //'token' => $permiso->user->fcm_token, // <-- aquí debes tener el token FCM del usuario
                'token' => 'deqOqmsSSoWb0K2Jg_Grdi:APA91bEwNISi1WFLb9CCm21gm-1wmFpuz4Q-ls85utbHGmeBL5dH-MHmlkiIKvKVjPfx4o8iNCzcigoRAMWzzYcbQtDoYLFptanGBOzndI6r5p0CQEWQzug',
                'title' => 'Solicitud Permiso',
                'message' => 'Tu solicitud de permiso ha sido aprobada.'
            ]);

            if ($response->successful()) {
                // opcional: log
                //\Log::info('Notificación enviada a Django FCM: ' . $response->body());
            } else {
                // \Log::error('Error enviando notificación a Django FCM: ' . $response->body());
            }
        } catch (\Exception $e) {
            //\Log::error('Error enviando POST a Django FCM: ' . $e->getMessage());
        }
        if ($permiso->estado === 'solicitado') {
            $permiso->update(['estado' => 'aprobado']);

            // Notificar al empleado (Laravel Notifications)
            // $permiso->user->notify(new PermisosNotification($permiso, 'aprobado'));

            // --- ENVIAR PUSH AL MICROSERVICIO DJANGO ---


            return redirect()->route('permisos.historial')->with('actualizado', 'Permiso aprobado y empleado notificado.');
        }

        return redirect()->route('permisos.historial')->with('error', 'El permiso ya fue procesado o no está en estado "solicitado".');
    }


    /**
     * Deniega un permiso. Solo accesible por administradores.
     */
    public function denegar(PermisoEmpleado $permiso)
    {
        //Gate::authorize('manage-permisos');
        try {
            //$response = Http::post('http://localhost:9000/api/fcm/send/', [
            $response = Http::post('http://django:8001/api/fcm/send/', [
                //'token' => $permiso->user->fcm_token, // <-- aquí debes tener el token FCM del usuario
                'token' => 'deqOqmsSSoWb0K2Jg_Grdi:APA91bEwNISi1WFLb9CCm21gm-1wmFpuz4Q-ls85utbHGmeBL5dH-MHmlkiIKvKVjPfx4o8iNCzcigoRAMWzzYcbQtDoYLFptanGBOzndI6r5p0CQEWQzug',
                'title' => 'Solicitud Permiso',
                'message' => 'Tu solicitud de permiso ha sido Rechazada.'
            ]);

            if ($response->successful()) {
                // opcional: log
                //\Log::info('Notificación enviada a Django FCM: ' . $response->body());
            } else {
                // \Log::error('Error enviando notificación a Django FCM: ' . $response->body());
            }
        } catch (\Exception $e) {
            //\Log::error('Error enviando POST a Django FCM: ' . $e->getMessage());
        }

        if ($permiso->estado === 'solicitado') {
            $permiso->update(['estado' => 'rechazado']);

            // Notificar al empleado
            $permiso->user->notify(new PermisosNotification($permiso, 'rechazado'));

            return redirect()->route('permisos.historial')->with('actualizado', 'Permiso denegado y empleado notificado.');
        }

        return redirect()->route('permisos.historial')->with('error', 'El permiso ya fue procesado o no está en estado "solicitado".');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PermisoEmpleado $permisoEmpleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PermisoEmpleado $permisoEmpleado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PermisoEmpleado $permisoEmpleado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PermisoEmpleado $permisoEmpleado)
    {
        //
    }
}
