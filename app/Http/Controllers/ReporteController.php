<?php

namespace App\Http\Controllers;


use App\Models\Departamento;
use App\Models\Empleado;
use App\Models\Postulante;
use App\Models\Contrato;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteDinamicoExport; 
use Illuminate\Support\Facades\DB; 

class ReporteController extends Controller
{
    // Listas "curadas" de atributos permitidos para los reportes
    // Clave = alias en la consulta, Valor = Etiqueta en el frontend
    private $atributos_empleado = [
        'empleados.id' => 'ID Empleado',
        'empleados.nombre_completo' => 'Nombre Completo',
        'empleados.telefono' => 'Teléfono',
        'empleados.direccion' => 'Dirección',
        'empleados.correo' => 'Email',
        'departamento_nombre' => 'Departamento', // Viene del JOIN
        'cargo_nombre' => 'Cargo', // Viene del JOIN
        'contrato_inicio' => 'Fecha de Contrato', // Viene del JOIN
        'contrato_tipo' => 'Tipo de Contrato', // Viene del JOIN (Alias de 'tipo')
        // 'contrato_sueldo' => 'Sueldo', // TODO: Descomentar cuando implementes el sueldo
    ];

    // Atributos de Postulante (sin cambios)
    private $atributos_postulante = [
        'nombres' => 'Nombres',
        'apellidos' => 'Apellidos',
        'email' => 'Email',
        'telefono' => 'Teléfono',
        'skills' => 'Skills',
        'experiencia_anios' => 'Años de Experiencia',
        'cv' => 'CV (Enlace)',
    ];


    /**
     * Muestra la vista principal de reportes con los filtros necesarios.
     */
    public function inicio()
    {
        $departamentos = Departamento::all();
        
        return view('reportes.inicio', [
            'atributos_empleado' => $this->atributos_empleado,
            'atributos_postulante' => $this->atributos_postulante,
            'departamentos' => $departamentos,
        ]);
    }

    /**
     * Genera el reporte basado en los filtros seleccionados.
     */
   public function generar(Request $request)
{
    $request->validate([
        'tipo_reporte' => 'required|in:empleados,departamentos,postulantes',
        'modo_reporte' => 'required|in:estatico,dinamico,ia',
        'formato' => 'required|in:html,pdf,excel',
        'fecha_inicio' => 'nullable|date|required_if:modo_reporte,dinamico',
        'fecha_fin' => 'nullable|date|required_if:modo_reporte,dinamico|after_or_equal:fecha_inicio',
        'departamentos_id' => 'nullable|array|required_if:tipo_reporte,departamentos',
    ]);

    try {

        // =============================
        //    VARIABLES PRINCIPALES
        // =============================
        $tipo = $request->input('tipo_reporte');
        $modo = $request->input('modo_reporte');
        $formato = $request->input('formato');

        // =============================
        //     IA HÍBRIDA — DEBE IR AQUÍ
        // =============================
        if ($modo === 'ia') {

            $comando = strtolower($request->input('comando_voz_texto', ''));

            // 1. Tipo de reporte
            $tipo = $this->detectarTipoReporte($comando);
            $request->merge(['tipo_reporte' => $tipo]);

            // 2. Formato
            $formatoDetectado = $this->detectarFormato($comando);
            $formato = $formatoDetectado;
            $request->merge(['formato' => $formatoDetectado]);

            // 3. Departamento
            $dep = $this->detectarDepartamento($comando);
            if ($dep) {
                $request->merge(['departamentos_id' => [$dep]]);
            }

            // 4. Atributos
            $attrs = $this->detectarAtributos($comando, $tipo);
            if (!empty($attrs)) {
                if ($tipo === 'empleados' || $tipo === 'departamentos') {
                    $request->merge(['atributos_empleado' => $attrs]);
                } else {
                    $request->merge(['atributos_postulante' => $attrs]);
                }
            }

            // 5. Fechas
            $fechas = $this->detectarFechas($comando);
            if ($fechas) {
                $modo = 'dinamico';
                $request->merge($fechas);
                $request->merge(['modo_reporte' => 'dinamico']);
            }
        }

        // ===============================================================
        //   AHORA recién construimos la consulta con los parámetros IA
        // ===============================================================

        $query = null;
        $columnas_seleccionadas = [];
        $atributos_solicitados = [];
        $titulos_columnas = [];
        $datos = [];


        // ---------------- EMPLEADOS / DEPARTAMENTOS ----------------
        if ($tipo === 'empleados' || $tipo === 'departamentos') {

            $atributos_solicitados = $request->input('atributos_empleado', []);

            if (empty($atributos_solicitados)) {
                $atributos_solicitados = array_keys($this->atributos_empleado);
            }

            $titulos_columnas = array_map(function($key) {
                return $this->atributos_empleado[$key] ?? $key;
            }, $atributos_solicitados);

            $columnas_seleccionadas = $this->buildEmpleadoSelect($atributos_solicitados);

            // Subconsulta contratos
            $subQueryContratos = Contrato::select(
                    'empleado_id',
                    DB::raw('MAX(fecha_inicio) as fecha_inicio')
                )
                ->groupBy('empleado_id');

            $query = Empleado::query()
                ->join('departamentos', 'empleados.departamento_id', '=', 'departamentos.id')
                ->join('cargos', 'empleados.cargo_id', '=', 'cargos.id')
                ->leftJoinSub($subQueryContratos, 'contratos_recientes', function ($join) {
                    $join->on('empleados.id', '=', 'contratos_recientes.empleado_id');
                })
                ->leftJoin('contratos', function ($join) {
                    $join->on('contratos_recientes.empleado_id', '=', 'contratos.empleado_id')
                         ->on('contratos_recientes.fecha_inicio', '=', 'contratos.fecha_inicio');
                });

            // Filtro de departamento
            if ($tipo === 'departamentos' && $request->has('departamentos_id')) {
                $query->whereIn('empleados.departamento_id', $request->input('departamentos_id'));
            }
        }

        // ---------------- POSTULANTES ----------------
        elseif ($tipo === 'postulantes') {

            $atributos_solicitados = $request->input('atributos_postulante', []);

            if (empty($atributos_solicitados)) {
                $atributos_solicitados = array_keys($this->atributos_postulante);
            }

            $titulos_columnas = array_map(function($key) {
                return $this->atributos_postulante[$key] ?? $key;
            }, $atributos_solicitados);

            $columnas_seleccionadas = $atributos_solicitados;

            $query = Postulante::query();
        }


        // ============================
        //      FILTRO FECHAS
        // ============================
        if ($modo === 'dinamico') {
            $tabla = ($tipo === 'postulantes') ? 'postulantes' : 'empleados';
            $query->whereBetween("{$tabla}.created_at", [
                $request->input('fecha_inicio'),
                $request->input('fecha_fin')
            ]);
        }


        // ============================
        //     EJECUTAR CONSULTA
        // ============================
        $datos = $query->select($columnas_seleccionadas)->get();


        // ============================
        //     EXPORTACIÓN
        // ============================
        switch ($formato) {
            case 'excel':
                return Excel::download(new ReporteDinamicoExport($datos, $titulos_columnas), 'reporte.xlsx');

            case 'pdf':
                $pdf = Pdf::loadView('reportes.resultado_pdf', [
                    'datos' => $datos,
                    'titulos' => $titulos_columnas,
                    'tipoReporte' => $tipo
                ])->setPaper('a4', 'landscape');
                return $pdf->stream('reporte.pdf');

            default:
                return view('reportes.resultado', [
                    'datos' => $datos,
                    'titulos' => $titulos_columnas,
                    'tipoReporte' => $tipo
                ]);
        }

    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', 
            'Error al generar el reporte (IA): ' . $e->getMessage()
        );
    }
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

    private function detectarTipoReporte($texto)
{
    if (str_contains($texto, 'empleado')) return 'empleados';
    if (str_contains($texto, 'departamento')) return 'departamentos';
    if (str_contains($texto, 'postulante')) return 'postulantes';
    return 'empleados'; // por defecto
}
private function detectarFormato($texto)
{
    if (str_contains($texto, 'pdf')) return 'pdf';
    if (str_contains($texto, 'excel') || str_contains($texto, 'xls')) return 'excel';
    if (str_contains($texto, 'html') || str_contains($texto, 'navegador')) return 'html';
    return 'html';
}
private function detectarDepartamento($texto)
{
    foreach (Departamento::all() as $dep) {
        if (str_contains($texto, strtolower($dep->nombre))) {
            return $dep->id;
        }
    }
    return null;
}
private function detectarAtributos($texto, $tipo)
{
    $resultado = [];

    $lista = $tipo === 'postulantes' 
        ? $this->atributos_postulante
        : $this->atributos_empleado;

    foreach ($lista as $clave => $etiqueta) {
        if (str_contains($texto, strtolower($etiqueta))) {
            $resultado[] = $clave;
        }
    }

    return $resultado;
}
private function detectarFechas($texto)
{
    $texto = strtolower($texto);

    $meses = [
        'enero' => '01', 'febrero' => '02', 'marzo' => '03',
        'abril' => '04', 'mayo' => '05', 'junio' => '06',
        'julio' => '07', 'agosto' => '08', 'septiembre' => '09',
        'octubre' => '10', 'noviembre' => '11', 'diciembre' => '12'
    ];

    $fecha_inicio = null;
    $fecha_fin = null;

    // 📌 1. Rango: “desde enero hasta hoy”
    if (preg_match('/desde (\w+) hasta hoy/', $texto, $m)) {
        $mes = $m[1];
        if (isset($meses[$mes])) {
            return [
                'fecha_inicio' => date('Y') . "-" . $meses[$mes] . "-01",
                'fecha_fin' => date('Y-m-d')
            ];
        }
    }

    // 📌 2. Rango: “desde enero hasta febrero”
    if (preg_match('/desde (\w+) hasta (\w+)/', $texto, $m)) {
        $mes1 = $m[1];
        $mes2 = $m[2];
        if (isset($meses[$mes1]) && isset($meses[$mes2])) {
            return [
                'fecha_inicio' => date('Y') . "-" . $meses[$mes1] . "-01",
                'fecha_fin' => date('Y') . "-" . $meses[$mes2] . "-28"
            ];
        }
    }

    // 📌 3. Rango simple: “enero a febrero”
    if (preg_match('/(\w+) a (\w+)/', $texto, $m)) {
        $mes1 = $m[1];
        $mes2 = $m[2];
        if (isset($meses[$mes1]) && isset($meses[$mes2])) {
            return [
                'fecha_inicio' => date('Y') . "-" . $meses[$mes1] . "-01",
                'fecha_fin' => date('Y') . "-" . $meses[$mes2] . "-28"
            ];
        }
    }

    // 📌 4. Solo un mes: “enero”
    foreach ($meses as $nombre => $num) {
        if (str_contains($texto, $nombre)) {
            return [
                'fecha_inicio' => date('Y') . "-$num-01",
                'fecha_fin' => date('Y-m-d')
            ];
        }
    }

    // 📌 5. “hoy”
    if (str_contains($texto, 'hoy')) {
        $hoy = date('Y-m-d');
        return [
            'fecha_inicio' => $hoy,
            'fecha_fin' => $hoy
        ];
    }

    // sin fechas encontradas
    return null;
}

}

