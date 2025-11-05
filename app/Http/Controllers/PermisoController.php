<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\PermisosNotification;
use App\Models\User; // Para buscar al administrador

class PermisoController extends Controller
{
    /**
     * Muestra el formulario para solicitar un nuevo permiso.
     */
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

        $permiso = Permiso::create([
            'user_id' => Auth::id(),
            'incidencia_id' => 1,
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
            $permisos = Permiso::with('user', 'incidencia')
                                ->orderBy('created_at', 'desc')
                                ->get();
        } else {
            $permisos = Permiso::with('incidencia')
                                ->where('user_id', Auth::id())
                                ->orderBy('created_at', 'desc')
                                ->get();
        }

        return view('permisos.historial', compact('permisos'));
    }

    /**
     * Aprueba un permiso. Solo accesible por administradores.
     */
    public function aprobar(Permiso $permiso)
    {
        Gate::authorize('manage-permisos');

        if ($permiso->estado === 'solicitado') {
            $permiso->update(['estado' => 'aprobado']);

            // Notificar al empleado
            $permiso->user->notify(new PermisosNotification($permiso, 'aprobado'));

            return redirect()->route('permisos.historial')->with('actualizado', 'Permiso aprobado y empleado notificado.');
        }

        return redirect()->route('permisos.historial')->with('error', 'El permiso ya fue procesado o no está en estado "solicitado".');
    }

    /**
     * Deniega un permiso. Solo accesible por administradores.
     */
    public function denegar(Permiso $permiso)
    {
        Gate::authorize('manage-permisos');

        if ($permiso->estado === 'solicitado') {
            $permiso->update(['estado' => 'rechazado']);

            // Notificar al empleado
            $permiso->user->notify(new PermisosNotification($permiso, 'rechazado'));

            return redirect()->route('permisos.historial')->with('actualizado', 'Permiso denegado y empleado notificado.');
        }

        return redirect()->route('permisos.historial')->with('error', 'El permiso ya fue procesado o no está en estado "solicitado".');
    }
}