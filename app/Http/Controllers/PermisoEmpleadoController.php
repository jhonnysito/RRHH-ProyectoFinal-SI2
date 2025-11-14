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
        ]);

        $permiso = PermisoEmpleado::create([
        'user_id' => Auth::id(),
        'incidencia_id' => $request->incidencia_id,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin,
        'motivo' => $request->motivo,
        'estado' => 'solicitado',
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
    public function historial()
    {
        if (Gate::allows('manage-permisos')) {
            $permisos = PermisoEmpleado::with('user', 'incidencia')
                                ->orderBy('created_at', 'desc')
                                ->get();
        } else {
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
   public function approve(PermisoEmpleado $permiso)
{
    Gate::authorize('manage-permisos');

    if ($permiso->estado === 'solicitado') {
        $permiso->update(['estado' => 'aprobado']);

        return redirect()
            ->route('permisos.historial')
            ->with('actualizado', 'Permiso aprobado exitosamente.');
    }

    return back()->with('error', 'Este permiso ya fue procesado.');
}

    /**
     * Deniega un permiso. Solo accesible por administradores.
     */
    public function deny(PermisoEmpleado $permiso)
{
    Gate::authorize('manage-permisos');

    if ($permiso->estado === 'solicitado') {
        $permiso->update(['estado' => 'rechazado']);

        return redirect()
            ->route('permisos.historial')
            ->with('actualizado', 'Permiso denegado correctamente.');
    }

    return back()->with('error', 'Este permiso ya fue procesado.');
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
