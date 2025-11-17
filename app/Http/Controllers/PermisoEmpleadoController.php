<?php

namespace App\Http\Controllers;

use App\Models\PermisoEmpleado;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\PermisosNotification;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // Para buscar al administrador

class PermisoEmpleadoController extends Controller
{

   public function solicitud()
{
    $incidencias = Incidencia::all();

    return view('permisos.solicitud', compact('incidencias'));
}

    /**
     * Procesa y guarda la solicitud de permiso.
     */
    public function enviarSolicitud(Request $request)
    {
        $request->validate([
            'incidencia_id' => 'required|exists:incidencias,id',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'motivo' => 'nullable|string|max:255',
            'archivo_adjunto' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048', 
        ]);
        
         $pathArchivo = null;
        if ($request->hasFile('archivo_adjunto')) {
            // Guarda el archivo en 'storage/app/public/permisos_respaldos'
            // La ruta guardada será 'permisos_respaldos/nombre_archivo.pdf'
            $pathArchivo = $request->file('archivo_adjunto')->store('permisos_respaldos', 'public');
        }

        $permiso = PermisoEmpleado::create([
        'user_id' => Auth::id(),
        'incidencia_id' => $request->incidencia_id,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin,
        'motivo' => $request->motivo,
        'estado' => 'solicitado',
        'archivo_adjunto' => $pathArchivo,
        'tenant_id' => tenant('id'),
    ]);

        // 1. Notificar al empleado (Línea corregida con chequeo)
        $user = Auth::user();
        
        if ($user) {
            //$user->notify(new PermisosNotification($permiso, 'solicitado')); // Línea 49
        }

        // 2. Notificar al administrador (o supervisor)
        $administradores = User::role('Administrador')->get();
        foreach ($administradores as $admin) {
            $admin->notify(new PermisosNotification($permiso, 'solicitado'));
        }

        return redirect()->route('permisos.historial')->with('creado', 'Solicitud de permiso enviada con éxito. Pendiente de aprobación.');
    }

    /**
     * Muestra el historial de permisos del empleado o la lista de solicitudes para el administrador.
     */
    public function historial(Request $request)
    {
        if ($request->user()->hasRole('Administrador')) {
            // El Admin ve TODO
            $permisos = PermisoEmpleado::with('user', 'incidencia')
                                        ->orderBy('created_at', 'desc')
                                        ->get();
        } else {
            // El Empleado ve SOLO LO SUYO
            $permisos = PermisoEmpleado::with('incidencia')
                                        ->where('user_id', Auth::id())
                                        ->orderBy('created_at', 'desc')
                                        ->get();
        }

        return view('permisos.historial', compact('permisos'));
    }

    /**
     * Aprueba un permiso. Solo accesible por administradores.
     */
 public function approve(Request $request,PermisoEmpleado $permisoEmpleado)
    {
        if (!$request->user()->hasRole('Administrador')) {
             abort(403, 'Acción no autorizada.');
        }

        if ($permisoEmpleado->estado === 'solicitado') {
            $permisoEmpleado->update(['estado' => 'aprobado']);
            
            // Aquí iría la integración con Asistencia (Incidencias) que hablamos
            // ... (crear Incidencia::create(...) por cada día) ...

            // Aquí iría la notificación al empleado
            // $permisoEmpleado->user->notify(...)

            return redirect()->route('permisos.historial')->with('actualizado', 'Permiso APROBADO exitosamente.');
        }
        return redirect()->route('permisos.historial')->with('error', 'Esta solicitud ya fue procesada.');
    }
    /**
     * Deniega un permiso. Solo accesible por administradores.
     */
  public function deny(Request $request,PermisoEmpleado $permisoEmpleado)
    {
         if (!$request->user()->hasRole('Administrador')) {
             abort(403, 'Acción no autorizada.');
         }

        if ($permisoEmpleado->estado === 'solicitado') {
            $permisoEmpleado->update(['estado' => 'rechazado']);

            // Aquí iría la notificación al empleado
            // $permisoEmpleado->user->notify(...)

            return redirect()->route('permisos.historial')->with('actualizado', 'Permiso RECHAZADO exitosamente.');
        }
        return redirect()->route('permisos.historial')->with('error', 'Esta solicitud ya fue procesada.');
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
    public function show(Request $request,PermisoEmpleado $permisoEmpleado)
    {
        // Solo el Admin puede ver detalles (o el propio empleado, si quisieras)
        if (!$request->user()->hasRole('Administrador')) {
             abort(403, 'Acción no autorizada.');
        }

        // Cargamos las relaciones para mostrar el nombre del user y la incidencia
        $permisoEmpleado->load('user', 'incidencia');

        return view('permisos.show', compact('permisoEmpleado'));
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
