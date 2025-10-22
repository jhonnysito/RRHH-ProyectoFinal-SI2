<?php

namespace App\Http\Controllers;

use App\Models\SolicitudEmpleo;
use App\Models\Postulante;
use Illuminate\Http\Request;

class SolicitudEmpleoController extends Controller
{
    // Mostrar todas las solicitudes de empleo
    public function index()
    {
        $solicitudes = SolicitudEmpleo::all();
        return view('solicitudes.index', compact('solicitudes'));
    }


    // Mostrar el formulario para crear una solicitud
    public function create()
    {
        $postulantes = Postulante::all(); // Obtener todos los postulantes
        return view('solicitudes.create', compact('postulantes'));
    }

    // Guardar una nueva solicitud
    public function store(Request $request)
    {
        $request->validate([
            'postulante_id' => 'required|exists:postulantes,id', // Asegurarse que el postulante exista
            'puesto' => 'required|string',
            'mensaje' => 'required|string',
        ]);

        SolicitudEmpleo::create([
            'postulante_id' => $request->postulante_id,
            'puesto' => $request->puesto,
            'mensaje' => $request->mensaje,
            'estado' => 'pendiente', // Estado inicial
        ]);

        return redirect()->route('solicitudes.index')->with('success', 'Solicitud de empleo enviada exitosamente.');
    }

    // Mostrar los detalles de una solicitud de empleo
    public function show($id)
    {
        $solicitud = SolicitudEmpleo::findOrFail($id);
        return view('solicitudes.show', compact('solicitud'));
    }

    // Mostrar el formulario para editar una solicitud de empleo
    public function edit($id)
    {
        $solicitud = SolicitudEmpleo::findOrFail($id);
        $postulantes = Postulante::all(); // Obtener todos los postulantes
        return view('solicitudes.edit', compact('solicitud', 'postulantes'));
    }

    // Actualizar una solicitud de empleo
    public function update(Request $request, $id)
    {
        $request->validate([
            'postulante_id' => 'required|exists:postulantes,id',
            'puesto' => 'required|string',
            'mensaje' => 'required|string',
        ]);

        $solicitud = SolicitudEmpleo::findOrFail($id);
        $solicitud->update([
            'postulante_id' => $request->postulante_id,
            'puesto' => $request->puesto,
            'mensaje' => $request->mensaje,
        ]);

        return redirect()->route('solicitudes.index')->with('success', 'Solicitud actualizada exitosamente.');
    }

    // Eliminar una solicitud de empleo
    public function destroy($id)
    {
        $solicitud = SolicitudEmpleo::findOrFail($id);
        $solicitud->delete();
        return redirect()->route('solicitudes.index')->with('success', 'Solicitud eliminada exitosamente.');
    }
}
