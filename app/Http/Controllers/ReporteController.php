<?php

namespace App\Http\Controllers;

// ASEGÚRATE DE TENER TODAS ESTAS IMPORTACIONES
use App\Models\Departamento;
use App\Models\Empleado;
use App\Models\Postulante;
use App\Models\Contrato;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteDinamicoExport; // <--- ¡¡CORREGIDO!! (Usa el nombre de tu archivo)
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
            // Variables principales
            $tipo = $request->input('tipo_reporte');
            $modo = $request->input('modo_reporte');
            $formato = $request->input('formato');
            
            $query = null;
            $columnas_seleccionadas = [];
            $atributos_solicitados = [];
            $titulos_columnas = [];
            $datos = [];

            // 1. Construir la consulta y seleccionar atributos
            if ($tipo === 'empleados' || $tipo === 'departamentos') {
                
                $atributos_solicitados = $request->input('atributos_empleado', []);

                // Lógica de Atributos por Defecto
                if (empty($atributos_solicitados)) {
                    $atributos_solicitados = array_keys($this->atributos_empleado);
                }

                $titulos_columnas = array_map(function($key) {
                    return $this->atributos_empleado[$key] ?? $key;
                }, $atributos_solicitados);

                // Construimos el SELECT dinámicamente
                $columnas_seleccionadas = $this->buildEmpleadoSelect($atributos_solicitados);
                
                // Subconsulta para obtener el contrato más reciente por empleado
                $subQueryContratos = Contrato::select(
                        'empleado_id',
                        DB::raw('MAX(fecha_inicio) as fecha_inicio') // ASUMO que el más reciente es el activo
                    )
                    ->groupBy('empleado_id');

                $query = Empleado::query()
                    ->join('departamentos', 'empleados.departamento_id', '=', 'departamentos.id')
                    ->join('cargos', 'empleados.cargo_id', '=', 'cargos.id')
                    // Left Join para que empleados sin contrato no desaparezcan
                    ->leftJoinSub($subQueryContratos, 'contratos_recientes', function ($join) {
                        $join->on('empleados.id', '=', 'contratos_recientes.empleado_id');
                    })
                    ->leftJoin('contratos', function ($join) {
                        $join->on('contratos_recientes.empleado_id', '=', 'contratos.empleado_id')
                             ->on('contratos_recientes.fecha_inicio', '=', 'contratos.fecha_inicio');
                    });
                
                // Filtro para reporte de Departamentos
                if ($tipo === 'departamentos') {
                    $query->whereIn('empleados.departamento_id', $request->input('departamentos_id'));
                }

            } elseif ($tipo === 'postulantes') {
                
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

            // 2. Aplicar filtros de Modo (Fechas, IA)
            if ($modo === 'dinamico') {
                $tabla = ($tipo === 'postulantes') ? 'postulantes' : 'empleados';
                // Filtra por fecha de CREACIÓN del empleado/postulante
                $query->whereBetween("{$tabla}.created_at", [
                    $request->input('fecha_inicio'),
                    $request->input('fecha_fin')
                ]);
            } elseif ($modo === 'ia') {
                // Lógica de IA (a implementar)
                // Se analizaría $request->input('comando_voz_texto') para aplicar filtros
            }

            // 3. Ejecutar la consulta
            if ($query) {
                // Usamos ->get() en lugar de ->select() al final
                $datos = $query->select($columnas_seleccionadas)->get();
            }

            // 4. Generar la respuesta (Exportación)
            switch ($formato) {
                case 'excel':
                    // ¡¡CORREGIDO!! (Usa el nombre de tu clase)
                    return Excel::download(new ReporteDinamicoExport($datos, $titulos_columnas), 'reporte.xlsx');
                
                case 'pdf':
                    $pdf = Pdf::loadView('reportes.resultado_pdf', [
                        'datos' => $datos,
                        'titulos' => $titulos_columnas,
                        'tipoReporte' => $tipo
                    ])->setPaper('a4', 'landscape'); 
                    return $pdf->stream('reporte.pdf');
                
                case 'html':
                default:
                    return view('reportes.resultado', [
                        'datos' => $datos,
                        'titulos' => $titulos_columnas,
                        'tipoReporte' => $tipo
                    ]);
            }

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al generar el reporte: ' . $e->getMessage());
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
}

