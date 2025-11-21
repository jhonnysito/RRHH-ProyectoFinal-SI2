<?php

namespace App\Http\Controllers;

// ASEGÚRATE DE TENER TODAS ESTAS IMPORTACIONES
use App\Models\Departamento;
use App\Models\Empleado;
use App\Models\Postulante;
use App\Models\Cargo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Http; // Usado para ambas APIs (OpenAI y Gemini)
use Illuminate\Support\Facades\Log; // Importar Log para el manejo de erroress
use App\Models\Contrato;
use App\Exports\ReporteEstaticoExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteDinamicoExport; // <--- ¡¡CORREGIDO!! (Usa el nombre de tu archivo)
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ReporteController extends Controller
{
    // Listas "curadas" de atributos permitidos para los reportes
    // Clave = alias en la consulta, Valor = Etiqueta en el frontend


    private $modelNames = [];

    private $reportes_estaticos = [
        [
            'id' => 'empleados_por_departamento',
            'nombre' => 'Empleados por Departamento',
            'tipo' => 'empleados',
            'atributos' => ['nombre', 'departamento_id']
        ],
        [
            'id' => 'contratos_por_vencer',
            'nombre' => 'Contratos Próximos a Vencer',
            'tipo' => 'empleados',
            'atributos' => ['nombre', 'fecha_fin']
        ],
        [
            'id' => 'asistencia_mensual',
            'nombre' => 'Reporte de Asistencia Mensual',
            'tipo' => 'empleados'
        ],
        [
            'id' => 'postulantes_descartados',
            'nombre' => 'Postulantes Descartados',
            'tipo' => 'postulantes'
        ],
        [
            'id' => 'permisos_mas_solicitados',
            'nombre' => 'Empleados con Más Permisos Solicitados',
            'tipo' => 'empleados'
        ],
    ];


    private $atributos_empleado = [
        'empleados.id' => 'ID Empleado',
        'empleados.nombre_completo' => 'Nombre Completo',
        'empleados.ci' => 'Cédula',
        'empleados.correo' => 'Email',
        'empleados.telefono' => 'Teléfono',
        'empleados.direccion' => 'Dirección',
        'empleados.estado' => 'Estado del Empleado',
        'departamentos.nombre as departamento' => 'Departamento',
        'cargos.nombre as cargo' => 'Cargo',
        'users.email as usuario_sistema' => 'Usuario del Sistema',
    ];

    private $atributos_asistencias = [
        'asistencias.fecha' => 'Fecha',
        'asistencias.hora_entrada' => 'Hora de Entrada',
        'asistencias.hora_salida' => 'Hora de Salida',
        'asistencias.estado' => 'Estado (Asistió / Falta / Tarde)',
        'asistencias.observacion' => 'Observación',
        'empleados.nombre_completo' => 'Empleado',
        'cargos.nombre as cargo' => 'Cargo',
        'departamentos.nombre as departamento' => 'Departamento',
    ];

    private $atributos_pagos = [
        'pagos_empleados.id' => 'ID Pago',
        'empleados.nombre_completo' => 'Empleado',
        'pagos_empleados.salario_base' => 'Salario Base',
        'pagos_empleados.total_bonos' => 'Total Bonos',
        'pagos_empleados.total_descuentos' => 'Total Descuentos',
        'pagos_empleados.total_neto' => 'Total Neto',
        'pagos_empleados.periodo_inicio' => 'Periodo Inicio',
        'pagos_empleados.periodo_fin' => 'Periodo Fin',
        'pagos_empleados.fecha_pago' => 'Fecha de Pago',
        'pagos_empleados.estado' => 'Estado del Pago',
    ];

    private $atributos_faltas = [
        'faltas_empleado.fecha' => 'Fecha',
        'faltas_empleado.tipo' => 'Tipo de Falta',
        'faltas_empleado.motivo' => 'Motivo',
        'faltas_empleado.horas_afectadas' => 'Horas Afectadas',
        'faltas_empleado.descuento_generado' => 'Descuento Aplicado',
        'empleados.nombre_completo' => 'Empleado',
    ];

    private $atributos_descuentos = [
        'descuentos_empleado.tipo' => 'Tipo de Descuento',
        'descuentos_empleado.monto' => 'Monto',
    ];

    private $atributos_permisos = [
        'incidencias.incidencia' => 'Tipo (Vacaciones, Enfermedad, etc.)',
        'incidencias.motivo' => 'Motivo',
        'incidencias.fecha_inicio' => 'Fecha Inicio',
        'incidencias.fecha_fin' => 'Fecha Fin',
        'incidencias.estado' => 'Estado (Solicitado/Aprobado/Rechazado)',
        'empleados.nombre_completo' => 'Empleado',
    ];


    private $atributos_geolocalizacion = [
        'location_records.name' => 'Empleado',
        'location_records.latitude' => 'Latitud',
        'location_records.longitude' => 'Longitud',
        'location_records.recorded_at' => 'Fecha y Hora Marcada',
    ];

    private $atributos_postulante = [
        'nombres' => 'Nombres',
        'apellidos' => 'Apellidos',
        'email' => 'Email',
        'telefono' => 'Teléfono',
        'skills' => 'Skills',
        'experiencia_anios' => 'Años de Experiencia',
        'cv' => 'Curriculum',
        'puntuacion' => 'Puntuación IA',
    ];


    private $atributos_puestos = [
        'puestos_disponibles.nombre' => 'Puesto',
        'puestos_disponibles.area' => 'Área',
        'puestos_disponibles.descripcion' => 'Descripción',
        'puestos_disponibles.vacantes' => 'Vacantes',
        'puestos_disponibles.tipo_contrato' => 'Tipo de Contrato',
        'puestos_disponibles.modalidad' => 'Modalidad',
        'puestos_disponibles.nivel' => 'Nivel',
        'puestos_disponibles.salario' => 'Salario',
        'puestos_disponibles.fecha_limite' => 'Fecha Límite',
        'puestos_disponibles.estado' => 'Estado',
    ];


    public function __construct()
    {
        $modelsPath = app_path('Models');
        $modelFiles = File::allFiles($modelsPath);

        foreach ($modelFiles as $file) {
            $this->modelNames[] = pathinfo($file->getFilename(), PATHINFO_FILENAME);
        }
    }

    /**
     * Muestra la vista principal de reportes con los filtros necesarios.
     */
    public function inicio()
    {
        // Traer todos los departamentos
        $departamentos = Departamento::all();

        // Traer todos los cargos
        $cargos = Cargo::all(); // Asegúrate de tener el modelo Cargo

        // Traer todos los empleados
        $empleados = Empleado::all(); // Asegúrate de tener el modelo Empleado

        // Retornar la vista con todos los datos
        return view('reportes.inicio', [
            'atributos_empleado' => $this->atributos_empleado,
            'atributos_postulante' => $this->atributos_postulante,
            'departamentos' => $departamentos,
            'cargos' => $cargos,
            'empleados' => $empleados,
            'reportes_estaticos' => $this->reportes_estaticos,
        ]);
    }

    /**
     * Genera el reporte basado en los filtros seleccionados.
     */
    public function generar(Request $request)
    {
        // Obtener filtros
        $departamento_id = $request->get('departamento_id');
        $cargo_id = $request->get('cargo_id');
        $empleado_id = $request->get('empleado_id');

        // Construir la query
        $query = Empleado::query();

        if ($departamento_id) {
            $query->where('departamento_id', $departamento_id);
        }

        if ($cargo_id) {
            $query->where('cargo_id', $cargo_id);
        }

        if ($empleado_id) {
            $query->where('id', $empleado_id);
        }

        // Obtener resultados filtrados
        $empleados_filtrados = $query->get();

        // Pasar datos a la vista (puede ser la misma que inicio)
        return view('reportes.inicio', [
            'atributos_empleado' => $this->atributos_empleado,
            'atributos_postulante' => $this->atributos_postulante,
            'departamentos' => Departamento::all(),
            'cargos' => Cargo::all(),
            'empleados' => Empleado::all(),
            'reportes_estaticos' => $this->reportes_estaticos,
            'empleados_filtrados' => $empleados_filtrados, // nuevos resultados
        ]);
    }
    public function dinamicos()
    {
        // Vista para interactuar por texto o voz
        return view('reportes.dinamicos');
    }



    public function generarDinamico(Request $request)
    {
        $departamentoEncontrado = false;
        $promptOriginal = $request->input('prompt');

        // Llamada a la IA para extraer palabras clave normalizadas
        $analisis  = $this->extraerPalabrasClaveConIA($promptOriginal);

        $modelosDetectados = $analisis['modelos_detectados'];
        $atributos = $this->obtenerAtributosPorModelo($modelosDetectados);

        //dd($atributos);
        $palabrasClave = $analisis['palabras_clave'];
        $atributosFiltrados = $this->obtenerAtributosConIA($modelosDetectados, $atributos, $palabrasClave);

        //dd($atributosFiltrados);
        //dd($atributosFiltrados);
        // Ahora $palabrasClave es un array de palabras como ['Recursos Humanos', 'Gerencia']
        //dd($palabrasClave); // solo para probar, luego usarás esto para filtrar


        // 4. Construir consultas dinámicas usando modelos y atributos filtrados
        $resultados = [];

        foreach ($modelosDetectados as $modelo) {
            $fullClass = "App\\Models\\{$modelo}";

            if (class_exists($fullClass) && !empty($atributosFiltrados[$modelo])) {

                // Filtrar por atributos filtrados
                $query = $fullClass::query()
                    ->where(function ($q) use ($atributosFiltrados, $modelo, $palabrasClave) {
                        foreach ($atributosFiltrados[$modelo] as $atributo) {
                            foreach ($palabrasClave as $clave) {
                                $q->orWhere($atributo, 'like', "%{$clave}%");
                            }
                        }
                    });

                $resultados[$modelo] = $query->get();
            } else {
                // No hay atributos filtrados: buscar registros relacionados
                if ($modelo == "Empleado") {
                    // Suponiendo que Empleado tiene relación con Departamento
                    $resultados[$modelo] = $fullClass::whereHas('departamento', function ($q) use ($palabrasClave) {
                        foreach ($palabrasClave as $clave) {
                            $q->orWhere('nombre', 'like', "%{$clave}%");
                        }
                    })->get();
                    // Mostrar los resultados
                    //dd($resultados[$modelo]->toArray());
                } else {
                    // Si no hay relación, devuelve todos los registros
                    $resultados[$modelo] = $fullClass::all();
                }
            }
        }

        // Convertir colecciones a arrays para ver los datos reales
        $resultadosArray = [];
        foreach ($resultados as $modelo => $coleccion) {
            $resultadosArray[$modelo] = $coleccion->toArray();
        }


        return view('reportes.dinamicos', [
            'resultados' => $resultadosArray, // ahora es un array simple
            'prompt' => $promptOriginal,
            'modelosDetectados' => $modelosDetectados,
            'atributosFiltrados' => $atributosFiltrados,
            'palabrasClave' => $palabrasClave
        ]);
    }

    public function obtenerAtributosConIA(array $modelosDetectados, array $atributosPorModelo, array $palabrasClave)
    {
        $apiKey = env('GEMINI_API_KEY');
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

        // 1. Construir un array con un ejemplo de registro por cada modelo
        $ejemplos = [];
        foreach ($modelosDetectados as $modelo) {
            $fullClass = "App\\Models\\{$modelo}";

            if (class_exists($fullClass)) {
                $registro = $fullClass::first(); // solo 1 registro
                if ($registro) {
                    // Guardamos solo los atributos que tenemos en $atributosPorModelo
                    $ejemploFiltrado = [];
                    foreach ($atributosPorModelo[$modelo] ?? [] as $attr) {
                        $ejemploFiltrado[$attr] = $registro->$attr ?? null;
                    }
                    $ejemplos[$modelo] = $ejemploFiltrado;
                }
            }
        }

        // 2. Preparar prompt para la IA
        $userPrompt = "
Eres un asistente experto en análisis de datos.
Tu tarea es recibir modelos, sus atributos, un ejemplo de registro y palabras clave extraídas de un prompt de usuario.
Debes analizar las palabras clave aver con que atributo coincide, no va a coincider exactamente
recorda que es reporte dinamico y el usuario por texto puede ingresar palabras que no coincidan exactamente
 con los datos que tiene algun registro, pero va aver alguna coincidencia y con el atributo que tenga
 coincidencia ese atributo quiero que devolvas para asi tener exactamente los atributos exactos para
 hacer luego la consulta y a que modelo correspode cada atributo que me vas a devolver.
solo devolveme ese atributo, no me devolvas todos los atributos que contiene cada tabla
Modelos detectados y sus atributos (obtenidos de la base de datos):
" . json_encode($atributosPorModelo, JSON_PRETTY_PRINT) . "

Ejemplos de registros:
" . json_encode($ejemplos, JSON_PRETTY_PRINT) . "

Palabras clave encontradas: " . implode(', ', $palabrasClave) . "

Devuelve SOLO un JSON válido que siga esta estructura exacta:

{
  \"NombreModelo1\": [\"atributo1\", \"atributo2\"],
  \"NombreModelo2\": [\"atributo1\", \"atributo2\"]
}

Solo atributos que coincidan en cada modelo y que corresponden a las palabras clave. No inventes atributos ni me devolvas todos los atributos de cada tabla.

";

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $userPrompt]
                    ]
                ]
            ]
        ];

        // 3. Llamada a la IA
        $response = Http::post($apiUrl, $payload);
        $data = json_decode($response->body(), true);



        // 4. Obtener el texto devuelto (CORREGIDO)
        $texto = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if ($texto) {
            // 1. Eliminar las comillas triples
            $texto = str_replace(['"""'], '', $texto);

            // 2. Eliminar ```json y ```
            $texto = preg_replace('/```json|```/', '', $texto);

            // 3. Trim final
            $texto = trim($texto);

            // 4. Decodificar JSON
            $atributosFiltrados = json_decode($texto, true);
            //dd($atributosFiltrados);
            if (is_array($atributosFiltrados)) {
                return $atributosFiltrados;
            }
        }

        return [];
    }



    public function obtenerAtributosPorModelo(array $modelosDetectados)
    {
        $atributosPorModelo = [];

        // Recorrer cada modelo recibido
        foreach ($modelosDetectados as $nombreModelo) {
            $fullClass = "App\\Models\\{$nombreModelo}";

            if (class_exists($fullClass)) {
                $instancia = new $fullClass;

                // Obtener tabla real
                $tabla = $instancia->getTable();

                // Obtener columnas reales de la tabla
                $columnas = Schema::getColumnListing($tabla);

                // Guardar columnas en el array final
                $atributosPorModelo[$nombreModelo] = $columnas;
            }
        }

        return $atributosPorModelo;
    }

    protected function extraerPalabrasClaveConIA($prompt)
    {
        $apiKey = env('GEMINI_API_KEY');
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";
        // Convertir lista de modelos en texto legible para Gemini
        $modelosDisponibles = $this->modelNames;
        // Instrucción: extrae solo palabras clave y capitaliza la primera letra
        $userPrompt = "
        Eres un asistente experto analizando solicitudes de reportes.

Modelos disponibles en la base de datos:
1) Qué modelos de esta lista están relacionados: " . json_encode($modelosDisponibles) . "

Objetivo:
1. Identificar qué MODELOS debe usar el sistema según el texto.
2. Identificar PALABRAS CLAVE relevantes (departamentos, cargos, empleados, etc.), si es
usuario ingresa RRHH o algo asi esas palabras convertilas para que me devolvas solo las palabras claves
o cosas asi
3. Responder SOLO en JSON válido con el siguiente formato:
4. exclui pa palabra reportes de lo que me vas a devolver

{
  \"modelos_detectados\": [\"Empleado\", \"Departamento\", \"Cargo\"],
  \"palabras_clave\": [\"Recursos Humanos\", \"Gerencia\"]
}

Texto del usuario:
\"$prompt\"
                   
                   ";

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $userPrompt]
                    ]
                ]
            ]
        ];

        $response = Http::post($apiUrl, $payload);
        $data = $response->json();

        if ($response->successful() && isset($data['candidates'][0]['content']['parts'][0]['text'])) {

            $jsonText = $data['candidates'][0]['content']['parts'][0]['text'];

            // 3. A veces Gemini devuelve el JSON con ```json ... ``` → lo limpiamos
            $jsonText = trim($jsonText);
            $jsonText = str_replace("```json", "", $jsonText);
            $jsonText = str_replace("```", "", $jsonText);

            // 4. Lo convertimos a array PHP
            $resultado = json_decode($jsonText, true);

            if ($resultado && isset($resultado['modelos_detectados'])) {

                // 5. FILTRAMOS modelos que realmente existen en tu proyecto
                $resultado['modelos_detectados'] = array_values(array_intersect(
                    $resultado['modelos_detectados'],
                    $modelosDisponibles
                ));

                return $resultado;
            }

            Log::warning("Respuesta JSON inválida de IA", ['raw' => $jsonText]);
            return ['modelos' => [], 'palabras_clave' => []];
        }

        Log::error('Error al extraer datos con IA', [
            'status' => $response->status(),
            'response' => $data
        ]);

        return ['modelos' => [], 'palabras_clave' => []];
    }

    public function normalizarPrompt($prompt)
    {
        // Separar por espacios
        $palabras = explode(' ', $prompt);

        // Aplicar ucfirst a cada palabra que no sea un artículo o preposición si quieres
        $palabras = array_map(function ($palabra) {
            // Eliminar signos de puntuación antes de capitalizar
            $palabraLimpia = trim($palabra, ".,;:!?");
            return ucfirst(strtolower($palabraLimpia));
        }, $palabras);

        return implode(' ', $palabras);
    }


    /**
     * Función de ayuda para construir el SELECT de empleados
     * y evitar ambigüedad de columnas.
     */
    private function buildEmpleadoSelect(array $atributos_solicitados): array
    {
        $select = [];
        // Mapeo de alias a columnas reales (con JOINs)
        $mapeo_columnas = [
            'empleados.id' => 'empleados.id',
            'empleados.nombre_completo' => 'empleados.nombre_completo',
            'empleados.telefono' => 'empleados.telefono',
            'empleados.direccion' => 'empleados.direccion',
            'empleados.correo' => 'empleados.correo',
            'departamento_nombre' => DB::raw('departamentos.nombre as departamento_nombre'),
            'cargo_nombre' => DB::raw('cargos.nombre as cargo_nombre'),
            'contrato_inicio' => DB::raw('contratos.fecha_inicio as contrato_inicio'),
            'contrato_tipo' => DB::raw('contratos.tipo as contrato_tipo'),
            // 'contrato_sueldo' => DB::raw('contratos.sueldo as contrato_sueldo'), // TODO: Descomentar
        ];

        foreach ($atributos_solicitados as $key) {
            if (isset($mapeo_columnas[$key])) {
                $select[] = $mapeo_columnas[$key];
            }
        }

        if (empty($select)) {
            $select[] = 'empleados.id';
        }

        return $select;
    }
}
