<?php

namespace App\Http\Controllers;

use App\Models\Conversacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    // Guarda un nuevo mensaje en una conversación existente
    public function store(Request $request, Conversacion $conversacion)
    {
        $request->validate([
            'contenido' => 'required|string',
        ]);

        // Política de seguridad
        if (!$conversacion->participantes->contains(Auth::user())) {
            abort(403, 'No tienes permiso para enviar mensajes a esta conversación.');
        }

        $conversacion->mensajes()->create([
            'user_id' => Auth::id(),
            'contenido' => $request->contenido,
        ]);

        // Actualizar el timestamp de la conversación para que aparezca primero
        $conversacion->touch();

        return redirect()->route('chat.show', $conversacion);
    }
}