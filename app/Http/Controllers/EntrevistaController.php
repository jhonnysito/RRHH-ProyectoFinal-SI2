<?php

namespace App\Http\Controllers;

use App\Models\Entrevista;
use Illuminate\Http\Request;
use App\Models\Postulante;
use App\Mail\EntrevistaAgendada;
use Illuminate\Support\Facades\Mail;

class EntrevistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    // Mostrar el formulario para programar entrevista
    public function crear($postulanteId)
    {
        $postulante = Postulante::findOrFail($postulanteId);
        return view('entrevistas.crear', compact('postulante'));
    }

    // Guardar la entrevista
    public function guardar(Request $request)
    {
        $request->validate([
            'postulante_id' => 'required|exists:postulantes,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'notas' => 'nullable|string',
        ]);

        $postulante = Postulante::findOrFail($request->postulante_id);

        // Crear la entrevista
        $entrevista = Entrevista::create([
            'postulante_id' => $postulante->id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'notas' => $request->notas,
        ]);

        // Enviar correo al postulante
        Mail::to($postulante->email)
            ->send(new EntrevistaAgendada($entrevista));

        return redirect()->back()->with('success', 'Entrevista agendada y correo enviado correctamente.');
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
    public function show(Entrevista $entrevista)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entrevista $entrevista)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entrevista $entrevista)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entrevista $entrevista)
    {
        //
    }
}
