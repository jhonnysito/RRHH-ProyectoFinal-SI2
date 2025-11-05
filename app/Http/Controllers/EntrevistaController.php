<?php

namespace App\Http\Controllers;

use App\Models\Entrevista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Postulante;
use App\Models\Evaluacion;
use App\Mail\EntrevistaAgendada;
use Illuminate\Support\Facades\Mail;

class EntrevistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filtro = $request->filtro; // 'pendientes' o 'evaluadas'
        $entrevistas = Entrevista::with('postulante', 'evaluaciones')->orderBy('fecha', 'desc')->get();
        return view('entrevistas.index', compact('entrevistas', 'filtro'));
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

        return redirect()->route('postulantes.index')
            ->with('success', 'Entrevista agendada y correo enviado correctamente.');
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
    public function verEvaluacion(Entrevista $entrevista)
    {
        // Traemos la primera evaluación de la entrevista (si existe)
        $evaluacion = $entrevista->evaluaciones()->first();

        if (!$evaluacion) {
            return redirect()->route('entrevistas.index')
                ->with('error', 'Esta entrevista aún no tiene evaluación.');
        }

        // Retornamos la vista con la evaluación
        return view('entrevistas.ver_evaluacion', compact('entrevista', 'evaluacion'));
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
    // Mostrar formulario para evaluar entrevista
    public function evaluar(Entrevista $entrevista)
    {
        return view('entrevistas.evaluar', compact('entrevista'));
    }

    // Guardar evaluación
    public function guardarEvaluacion(Request $request, Entrevista $entrevista)
    {
        $request->validate([
            'puntaje_comunicacion' => 'required|integer|min:0|max:10',
            'puntaje_conocimiento' => 'required|integer|min:0|max:10',
            'puntaje_actitud' => 'required|integer|min:0|max:10',
            'puntaje_trabajo_equipo' => 'required|integer|min:0|max:10',
            'resultado_final' => 'required|string',
            'comentarios' => 'nullable|string',
        ]);

        $tenant_id = Auth::user()->tenant_id;
        $evaluacion = new Evaluacion();
        $evaluacion->entrevista_id = $entrevista->id;
        $evaluacion->evaluador_id = Auth::id(); // quien evalúa
        $evaluacion->puntaje_comunicacion = $request->puntaje_comunicacion;
        $evaluacion->puntaje_conocimiento = $request->puntaje_conocimiento;
        $evaluacion->puntaje_actitud = $request->puntaje_actitud;
        $evaluacion->puntaje_trabajo_equipo = $request->puntaje_trabajo_equipo;
        $evaluacion->puntaje_total = $request->puntaje_comunicacion + $request->puntaje_conocimiento + $request->puntaje_actitud + $request->puntaje_trabajo_equipo;
        $evaluacion->resultado_final = $request->resultado_final;
        $evaluacion->comentarios = $request->comentarios;
        $evaluacion->tenant_id = $tenant_id;

        $evaluacion->save();

        return redirect()->route('entrevistas.index')->with('success', 'Evaluación guardada correctamente.');
    }
}
