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

    public function guardarEvaluacion(Request $request, Entrevista $entrevista)
    {
        //dd($request->all());
        $request->validate([
            // Características personales
            'apariencia_profesional' => 'required|integer|min:0|max:10',
            'actitud' => 'required|integer|min:0|max:10',
            'conversacion' => 'required|integer|min:0|max:10',
            'cooperacion_entrevistador' => 'required|integer|min:0|max:10',
            'relaciones_interpersonales' => 'required|integer|min:0|max:10',

            // Características relacionadas con el puesto
            'experiencia_puesto' => 'required|integer|min:0|max:10',
            'conocimiento_cargo' => 'required|integer|min:0|max:10',
            'perfil_puesto' => 'required|integer|min:0|max:10',
            'valoracion_curricular' => 'required|integer|min:0|max:10',
            'adecuacion_puesto' => 'required|integer|min:0|max:10',

        ]);
        $tenant_id = Auth::user()->tenant_id;
        //dd($tenant_id);
        $evaluacion = new Evaluacion();
        $evaluacion->entrevista_id = $entrevista->id;
        $evaluacion->evaluador_id = Auth::id(); // quien evalúa
        $evaluacion->tenant_id = $tenant_id;

        // Guardar características personales
        $evaluacion->apariencia_profesional = $request->apariencia_profesional;
        $evaluacion->actitud = $request->actitud;
        $evaluacion->conversacion = $request->conversacion;
        $evaluacion->cooperacion_entrevistador = $request->cooperacion_entrevistador;
        $evaluacion->relaciones_interpersonales = $request->relaciones_interpersonales;

        // Guardar características del puesto
        $evaluacion->experiencia_puesto = $request->experiencia_puesto;
        $evaluacion->conocimiento_cargo = $request->conocimiento_cargo;
        $evaluacion->perfil_puesto = $request->perfil_puesto;
        $evaluacion->valoracion_curricular = $request->valoracion_curricular;
        $evaluacion->adecuacion_puesto = $request->adecuacion_puesto;

        // Calcular total de puntuación sobre 100
        $total_caracteristicas_personales = $evaluacion->apariencia_profesional + $evaluacion->actitud + $evaluacion->conversacion + $evaluacion->cooperacion + $evaluacion->relaciones_interpersonales;
        $total_caracteristicas_puesto = $evaluacion->experiencia_puesto + $evaluacion->conocimiento_cargo + $evaluacion->perfil_puesto + $evaluacion->valoracion_curricular + $evaluacion->adecuacion_puesto;

        $total_maximo = 10 * 10; // 10 atributos x 10 puntos cada uno
        $evaluacion->total_puntuacion = round((($total_caracteristicas_personales + $total_caracteristicas_puesto) / $total_maximo) * 100, 2);

        // Determinar candidato según total_puntuacion
        if ($evaluacion->total_puntuacion < 40) {
            $evaluacion->candidato = 'Malo';
        } elseif ($evaluacion->total_puntuacion < 60) {
            $evaluacion->candidato = 'Regular';
        } elseif ($evaluacion->total_puntuacion < 80) {
            $evaluacion->candidato = 'Bueno';
        } else {
            $evaluacion->candidato = 'Muy Bueno';
        }

        // Comentario final
        $evaluacion->comentario_final = $request->comentario_final;

        $evaluacion->save();

        return redirect()->route('entrevistas.index')->with('success', 'Evaluación guardada correctamente.');
    }
}
