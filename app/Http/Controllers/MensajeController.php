<?php

// app/Http/Controllers/MensajeController.php
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
        $empleado = Auth::user()->empleado;
        if ($conversacion->empleado_id !== $empleado->id && !Auth::user()->hasRole('Recursos Humanos')) {
            abort(403);
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