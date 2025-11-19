<?php

namespace App\Http\Controllers;

use App\Models\PermisoEmpleado;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\PermisosNotification;
use App\Models\User; // Para buscar al administrador

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
        $administradores = User::role('Administrador')->get();
        foreach ($administradores as $admin) {
            $admin->notify(new PermisosNotification($permiso, 'solicitado'));
        }

        return redirect()
            ->route('permisos.historial')
            ->with('creado', 'Solicitud de permiso enviada con éxito. Pendiente de aprobación.');
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
    public function aprobar($id)
    {
        // Buscar el permiso
        $permiso = PermisoEmpleado::findOrFail($id);

        // Verificar estado
        if ($permiso->estado === 'solicitado') {

            $permiso->update(['estado' => 'aprobado']);

            // Notificar al empleado
            if ($permiso->user) {
                $permiso->user->notify(new PermisosNotification($permiso, 'aprobado'));
            }

            return redirect()->route('permisos.historial')
                ->with('actualizado', 'Permiso aprobado y empleado notificado.');
        }

        return redirect()->route('permisos.historial')
            ->with('error', 'El permiso ya fue procesado o no está en estado "solicitado".');
    }

    /**
     * Deniega un permiso. Solo accesible por administradores.
     */
    public function denegar($id)
    {
        // Buscar el permiso
        $permiso = PermisoEmpleado::findOrFail($id);

        if ($permiso->estado === 'solicitado') {

            $permiso->update(['estado' => 'rechazado']);

            // Notificar al empleado
            if ($permiso->user) {
                $permiso->user->notify(new PermisosNotification($permiso, 'rechazado'));
            }

            return redirect()->route('permisos.historial')
                ->with('actualizado', 'Permiso denegado y empleado notificado.');
        }

        return redirect()->route('permisos.historial')
            ->with('error', 'El permiso ya fue procesado o no está en estado "solicitado".');
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
