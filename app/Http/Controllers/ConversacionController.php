<?php

// app/Http/Controllers/ConversacionController.php
namespace App\Http\Controllers;

use App\Models\Conversacion;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversacionController extends Controller
{
    // Muestra la lista de conversaciones para el empleado autenticado
    public function index()
    {
        $user = Auth::user();
        $empleado = Empleado::where('user_id', $user->id)->firstOrFail();

        $conversaciones = Conversacion::where('empleado_id', $empleado->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('chat.index', compact('conversaciones'));
    }

    // Muestra el formulario para crear una nueva conversación
    public function create()
    {
        return view('chat.create');
    }

    // Guarda una nueva conversación y el primer mensaje
    public function store(Request $request)
    {
        $request->validate([
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string',
        ]);

        $user = Auth::user();
        $empleado = Empleado::where('user_id', $user->id)->firstOrFail();

        // Crear la conversación
        $conversacion = Conversacion::create([
            'tenant_id' => tenant('id'),
            'empleado_id' => $empleado->id,
            'asunto' => $request->asunto,
        ]);

        // Crear el primer mensaje
        $conversacion->mensajes()->create([
            'user_id' => $user->id,
            'contenido' => $request->mensaje,
        ]);

        return redirect()->route('chat.show', $conversacion);
    }

    // Muestra una conversación específica
    public function show(Conversacion $conversacion)
    {
        // Política de seguridad: Asegurarse de que el empleado solo vea sus chats
        $empleado = Auth::user()->empleado;
        if ($conversacion->empleado_id !== $empleado->id && !Auth::user()->hasRole('Recursos Humanos')) {
            abort(403);
        }

        return view('chat.show', compact('conversacion'));
    }
    
    // --- Métodos para RRHH ---

    // Muestra todas las conversaciones a RRHH
    public function adminIndex()
    {
        // Aquí asumimos que tienes un rol "Recursos Humanos"
        $this->authorize('viewAny', Conversacion::class); // O usa un Gate/Middleware

        $conversaciones = Conversacion::where('tenant_id', tenant('id'))
            ->orderBy('updated_at', 'desc')
            ->get();
            
        return view('chat.admin-index', compact('conversaciones'));
    }
}