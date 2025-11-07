<?php

// app/Http/Controllers/ConversacionController.php
namespace App\Http\Controllers;

use App\Models\Conversacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversacionController extends Controller
{
    /**
     * Muestra la lista unificada de conversaciones del usuario.
     * (¡Esta función ya la tenías perfecta!)
     */
    public function index()
    {
        $user = Auth::user();

        $conversaciones = $user->conversaciones()
            ->withCount('mensajes') // Es buena idea contar los mensajes
            ->latest('updated_at') // 'latest' es un atajo para orderBy('updated_at', 'desc')
            ->get();

        return view('chat.index', compact('conversaciones')); // Asegúrate de tener esta vista
    }

    /**
     * Muestra el formulario para crear una nueva conversación.
     * (¡Esta función ya la tenías perfecta!)
     */
    public function create()
    {
        $funcionarios_rrhh = User::role('Recursos Humanos')
                                ->where('id', '!=', Auth::id()) // No mostrarte a ti mismo en la lista
                                ->get();

        return view('chat.create', compact('funcionarios_rrhh'));
    }

    /**
     * ¡CORREGIDO!
     * Guarda la nueva conversación, adjunta participantes y guarda el primer mensaje.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'destinatario_id' => 'required|exists:users,id', // El ID del funcionario de RRHH
        ]);

        $iniciador = Auth::user();

        // 1. Crear la conversación
        $conversacion = Conversacion::create([
            'tenant_id' => tenant('id'),
            'asunto' => $request->asunto,
        ]);

        // 2. Adjuntar los participantes a la tabla pivote
        $conversacion->participantes()->attach($iniciador->id);
        $conversacion->participantes()->attach($request->destinatario_id);

        // 3. Crear el primer mensaje
        $conversacion->mensajes()->create([
            'user_id' => $iniciador->id,
            'contenido' => $request->mensaje,
        ]);

        // 4. Redirigir al chat
        return redirect()->route('chat.show', $conversacion);
    }

    /**
     * ¡CORREGIDO!
     * Muestra una conversación específica SÓLO a los participantes.
     */
    public function show(Conversacion $conversacion)
    {
        // Política de seguridad simplificada:
        // Si el usuario autenticado no está en la lista de participantes, no puede ver el chat.
        if (!$conversacion->participantes->contains(Auth::user())) {
            abort(403, 'No tienes permiso para ver esta conversación.');
        }

        // Cargar los mensajes y el autor de cada mensaje
        $conversacion->load('mensajes.user');

        return view('chat.show', compact('conversacion')); // Asegúrate de tener esta vista
    }
}