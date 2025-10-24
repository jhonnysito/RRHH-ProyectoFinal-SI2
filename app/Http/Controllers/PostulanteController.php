<?php

namespace App\Http\Controllers;

use App\Models\Postulante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SolicitudEmpleo;
use App\Services\CVTextExtractor; // Incluir el servicio
use Illuminate\Support\Facades\Http; // Usado para ambas APIs (OpenAI y Gemini)
use Illuminate\Support\Facades\Log; // Importar Log para el manejo de errores
use App\Models\Puesto_Disponible;

class PostulanteController extends Controller
{
    protected $cvTextExtractor;

    // Inyectamos el servicio de extracción de texto en el controlador
    public function __construct(CVTextExtractor $cvTextExtractor)
    {
        $this->cvTextExtractor = $cvTextExtractor;
    }

    // Mostrar todos los postulantes
    public function index()
    {
        $postulantes = Postulante::where('tenant_id', tenant('id'))
            ->orderByDesc('puntuacion') // 🔹 Ordenar de mayor a menor
            ->get();

        return view('postulantes.index', compact('postulantes'));
    }


    // Mostrar el formulario para crear un nuevo postulante
    public function create()
    {
        return view('postulantes.create'); // Vista para crear un nuevo postulante
    }

    // Crear un nuevo postulante con archivo CV
    public function store(Request $request)
    {   //dd($request);
        $request->validate([
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'email' => 'required|email|unique:postulantes',
            'telefono' => 'required|string',
            // 'cv' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // Validación del archivo
            'skills' => 'nullable|string', // Validación del campo skills (ahora es solo texto)
            'experiencia_anios' => 'nullable|integer'
        ]);

        // Convertir el campo 'skills' en un array JSON
        $skills = $request->skills ? explode(',', $request->skills) : [];

        // Inicializar variables para la ruta y URL
        $cvPath = null; // Ruta relativa en el disco (ej: 'cv/nombre.pdf')
        $cvUrl = null;  // URL pública (ej: 'http://localhost/storage/cv/nombre.pdf')

        // Subir el archivo de CV
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cv', 'public'); // Subir a 'storage/app/public/cv'
            $cvUrl = Storage::disk('public')->url($cvPath); // Obtener la URL del archivo
        }

        // Extraer texto del CV (CORRECCIÓN: Se pasa $cvPath - la ruta relativa)
        $cvText = '';
        if ($cvPath) { // Verificar si el archivo fue subido
            $cvText = $this->extraerTextoDeCV($cvPath);
        }

        // *** LLAMADAS A GEMINI ***
        $habilidades = $this->analizarHabilidadesConGemini($cvText); // <-- Método con Gemini
        $puestoSugerido = $this->recomendarPuestoConGemini($cvText); // <-- Método con Gemini
        // ************************

        // Crear el postulante en la base de datos
        Postulante::create([
            'tenant_id'   => $tenant_id,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'cv' => $cvUrl, // Guardar la URL del archivo
            'skills' => json_encode($skills), // Guardar como JSON válido
            'experiencia_anios' => $request->experiencia_anios,
            // NUEVO: Guardar los resultados de la IA
            'ai_skills' => $habilidades,
            'ai_suggested_job' => $puestoSugerido
        ]);

        return redirect()->route('puesto_disponible.ver', $puesto->id)
            ->with('success', 'Tu postulación fue enviada correctamente.');
    }

    /**
     * Envía el texto del CV a Gemini para extraer habilidades.
     * @param string $cvText El texto extraído del CV.
     * @return string Las habilidades extraídas por la IA.
     */
    public function analizarHabilidadesConGemini($cvText)
    {
        $apiKey = env('GEMINI_API_KEY');
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

        // CORRECCIÓN: Se elimina systemInstruction y se añade al prompt
        $instruction = 'Eres un asistente que clasifica y lista las habilidades de un currículum en formato de lista separada por comas. ';
        $userPrompt = $instruction . 'Por favor, extrae las habilidades de este CV en formato de lista separada por comas: ' . $cvText;

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $userPrompt]
                    ]
                ]
            ],
        ];

        $response = Http::post($apiUrl, $payload);
        $data = $response->json();

        // MANEJO DE ERRORES: La estructura de respuesta de Gemini es diferente.
        if ($response->successful() && isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            $habilidades = $data['candidates'][0]['content']['parts'][0]['text'];
        } else {
            // Registrar el error para depuración
            Log::error('Gemini Error al analizar habilidades:', ['status' => $response->status(), 'response' => $data]);
            $habilidades = 'No se pudieron extraer habilidades debido a un error de la IA o de la conexión.';
        }

        return $habilidades;
    }

    /**
     * Envía el texto del CV a Gemini para recomendar un puesto.
     * @param string $cvText El texto extraído del CV.
     * @return string El puesto sugerido por la IA.
     */
    public function recomendarPuestoConGemini($cvText)
    {
        $apiKey = env('GEMINI_API_KEY');
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

        // CORRECCIÓN: Se elimina systemInstruction y se añade al prompt
        $instruction = 'Eres un asistente que recomienda puestos a postulantes según su CV. Responde solo con el nombre del puesto. ';
        $userPrompt = $instruction . 'Basado en el siguiente CV, ¿qué puesto debería ocupar el postulante? CV: ' . $cvText;

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $userPrompt]
                    ]
                ]
            ],
        ];

        $response = Http::post($apiUrl, $payload);
        $data = $response->json();

        // MANEJO DE ERRORES para Gemini
        if ($response->successful() && isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            $puestoSugerido = $data['candidates'][0]['content']['parts'][0]['text'];
        } else {
            Log::error('Gemini Error al recomendar puesto:', ['status' => $response->status(), 'response' => $data]);
            $puestoSugerido = 'Puesto no sugerido debido a un error de la IA o de la conexión.';
        }
        return $puestoSugerido;
    }

    /**
     * Envía el CV y las habilidades requeridas a Gemini para filtrar.
     * @param string $cvText El texto extraído del CV.
     * @param array $skillsRequeridas Un array de habilidades a buscar.
     * @return string Resultado del filtrado (SÍ o NO).
     */
    public function filtrarCVConIA($cvText, $skillsRequeridas)
    {
        $apiKey = env('GEMINI_API_KEY');
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

        // CORRECCIÓN: Se elimina systemInstruction y se añade al prompt
        $instruction = 'Eres un asistente que filtra currículums basados en habilidades clave. Responde únicamente SÍ o NO.';
        $userPrompt = $instruction . ' ¿Este CV contiene las siguientes habilidades: ' . implode(', ', $skillsRequeridas) . '? Responde únicamente SÍ o NO. CV: ' . $cvText;

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $userPrompt]
                    ]
                ]
            ],
        ];

        $response = Http::post($apiUrl, $payload);
        $data = $response->json();

        // MANEJO DE ERRORES
        if ($response->successful() && isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            $resultado = $data['candidates'][0]['content']['parts'][0]['text'];
        } else {
            Log::error('Gemini Error al filtrar CV:', ['status' => $response->status(), 'response' => $data]);
            $resultado = 'Error de filtrado o conexión.';
        }

        return $resultado; // Resultado del filtrado
    }

    // *** MÉTODOS OBSOLETOS DE OPENAI (Renombrados para evitar conflictos) ***
    // Si aún necesitas OpenAI en otro lugar, puedes usar los métodos originales, pero
    // para el store() ahora usamos los de Gemini.
    public function analizarHabilidadesConChatGPT($cvText)
    {
        Log::warning('Se llamó al método antiguo de OpenAI. Use analizarHabilidadesConGemini.');
        return 'Usando método antiguo (OpenAI).';
    }

    public function recomendarPuestoConIA($cvText)
    {
        Log::warning('Se llamó al método antiguo de OpenAI. Use recomendarPuestoConGemini.');
        return 'Usando método antiguo (OpenAI).';
    }
    // *************************************************************************


    public function extraerTextoDeCV($relativePath)
    {
        // Se obtiene la extensión directamente de la ruta relativa
        $extension = pathinfo($relativePath, PATHINFO_EXTENSION);

        // Se construye la ruta física absoluta usando storage_path()
        $rutaFisica = storage_path('app/public/' . $relativePath);

        if ($extension == 'pdf') {
            // Se pasa la ruta física correcta al servicio
            return $this->cvTextExtractor->extraerTextoPDF($rutaFisica);
        } elseif ($extension == 'docx' || $extension == 'doc') {
            // Aseguramos que .doc también use el extractor DOCX (asumiendo que PHPWord lo maneja)
            return $this->cvTextExtractor->extraerTextoDOCX($rutaFisica);
        }
        return '';
    }


    // Mostrar los detalles de un postulante específico
    public function show($id)
    {
        $postulante = Postulante::findOrFail($id); // Buscar el postulante por ID
        return view('postulantes.show', compact('postulante')); // Pasar los datos a la vista
    }

    // Mostrar el formulario para editar un postulante
    public function edit($id)
    {
        $postulante = Postulante::findOrFail($id); // Buscar el postulante por ID
        return view('postulantes.edit', compact('postulante')); // Pasar los datos a la vista
    }

    // Actualizar un postulante
    public function update(Request $request, $id)
    {
        // Validación de los datos del formulario
        $request->validate([
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'email' => 'required|email',
            'telefono' => 'required|string',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // Validación del archivo
            'skills' => 'nullable|string', // Validación de habilidades
        ]);

        // Buscar el postulante por ID
        $postulante = Postulante::findOrFail($id);

        // Si hay habilidades, convertirlas en un array y luego en JSON
        $skills = $request->skills ? explode(',', $request->skills) : []; // Convertir la cadena de habilidades separadas por comas en un array

        // Si se subió un archivo de CV, subirlo al almacenamiento público
        $cvUrl = $postulante->cv; // Mantener la URL del CV anterior si no se sube un nuevo CV
        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cv', 'public'); // Subir el archivo a 'storage/app/public/cv'
            $cvUrl = Storage::disk('public')->url($cvPath); // Obtener la URL pública del archivo
        }

        // Si se subió un nuevo CV, re-analizarlo con IA (opcional, pero buena práctica)
        if ($cvPath) {
            $cvText = $this->extraerTextoDeCV($cvPath);
            $habilidades = $this->analizarHabilidadesConGemini($cvText);
            $puestoSugerido = $this->recomendarPuestoConGemini($cvText);
        } else {
            // Si no se subió un nuevo CV, mantener los datos de IA existentes
            $habilidades = $postulante->ai_skills;
            $puestoSugerido = $postulante->ai_suggested_job;
        }

        // Actualizar el postulante
        $postulante->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'cv' => $cvUrl, // Guardar la URL del archivo
            'skills' => json_encode($skills), // Convertir el array de habilidades a JSON
            'experiencia_anios' => $request->experiencia_anios,
            'ai_skills' => $habilidades,
            'ai_suggested_job' => $puestoSugerido,
        ]);

        return redirect()->route('postulantes.index')->with('success', 'Postulante actualizado exitosamente.');
    }


    // Eliminar un postulante
    public function destroy($id)
    {
        $postulante = Postulante::findOrFail($id); // Buscar el postulante por ID

        // OPCIONAL: Eliminar el archivo del CV del disco (Buena práctica)
        if ($postulante->cv) {
            // Extrae la ruta relativa (ej: cv/nombre.pdf) eliminando la URL base del storage
            $relativePath = str_replace(Storage::disk('public')->url(''), '', $postulante->cv);
            Storage::disk('public')->delete($relativePath);
        }

        $postulante->delete(); // Eliminar el postulante
        return redirect()->route('postulantes.index')->with('success', 'Postulante eliminado exitosamente.');
    }


    public function guardar(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'email' => 'required|email|unique:postulantes',
            'telefono' => 'required|string',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // Validación del archivo
            'skills' => 'nullable|string', // Validación del campo skills (ahora es solo texto)
            'experiencia_anios' => 'nullable|integer'
        ]);

        $puesto = Puesto_Disponible::findOrFail($id);
        // Convertir el campo 'skills' en un array JSON
        $skills = $request->skills ? explode(',', $request->skills) : [];

        // Inicializar variables para la ruta y URL
        $cvPath = null; // Ruta relativa en el disco (ej: 'cv/nombre.pdf')
        $cvUrl = null;  // URL pública (ej: 'http://localhost/storage/cv/nombre.pdf')

        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cv', 'public'); // Subir a storage/app/public/cv
            $cvFileName = basename($cvPath); // Solo el nombre del archivo, ej: 2OdDbPEazyqNqNmFAi9BrrQsnp751bnPK4avQHoo.pdf
        }

        // Extraer texto del CV (CORRECCIÓN: Se pasa $cvPath - la ruta relativa)
        $cvText = '';
        if ($cvPath) { // Verificar si el archivo fue subido
            $cvText = $this->extraerTextoDeCV($cvPath);
        }
        // 🧠 Obtener puntuación desde Gemini
        $puntuacion = $this->calcularPuntuacionConGemini($cvText);
        // *** LLAMADAS A GEMINI ***
        //$habilidades = $this->analizarHabilidadesConGemini($cvText); // <-- Método con Gemini
        //$puestoSugerido = $this->recomendarPuestoConGemini($cvText); // <-- Método con Gemini
        // ************************
        //dd($puntuacion);
        // Crear el postulante en la base de datos
        Postulante::create([
            'tenant_id'   => $puesto->tenant_id,
            'puesto_disponible_id' => $puesto->id,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'cv' => $cvFileName, // Guardar la URL del archivo
            'skills' => json_encode($skills), // Guardar como JSON válido
            'experiencia_anios' => $request->experiencia_anios,
            'puntuacion'       => round(floatval($puntuacion), 2), // ✅ casteo a float y redondeo a 2 decimales
            // NUEVO: Guardar los resultados de la IA
            //'ai_skills' => $habilidades,
        ]);
        $puesto->postulado = $puesto->postulantes()->count() > 0 ? true : false;
        $puesto->save();
        return redirect()->route('puesto_disponibles')
            ->with('success', 'Tu postulación fue enviada correctamente.');
    }
    public function calcularPuntuacionConGemini($cvText)
    {
        $apiKey = env('GEMINI_API_KEY');
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        // 🔹 Prompt modificado para pedir puntuación del 1 al 10 (con decimales permitidos)
        $prompt = "Eres un reclutador experto. Evalúa el siguiente texto de un currículum (CV) y otorga una puntuación de **1 a 10**, donde 1 es muy débil y 10 es excelente. 
    Considera factores como experiencia, claridad, redacción y habilidades profesionales. 
    Responde únicamente con el número (por ejemplo: 8.5 o 9.0).
    Texto del CV:
    {$cvText}";

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [['text' => $prompt]]
                ]
            ],
        ];

        $response = Http::post($apiUrl, $payload);
        $data = $response->json();

        if ($response->successful() && isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            $puntuacionTexto = trim($data['candidates'][0]['content']['parts'][0]['text']);

            // 🔹 Extraer solo el número (con posible decimal)
            $puntuacion = floatval(preg_replace('/[^0-9.]/', '', $puntuacionTexto));

            // 🔹 Validar que esté dentro del rango 1-10
            //dd($puntuacion);
            if ($puntuacion >= 1 && $puntuacion <= 10) {
                return $puntuacion;
            } else {
                Log::warning('Gemini devolvió una puntuación fuera de rango', ['puntuacion' => $puntuacion]);
                return null;
            }
        } else {
            Log::error('Gemini Error al calcular puntuación', ['status' => $response->status(), 'response' => $data]);
            return null;
        }
    }
}
