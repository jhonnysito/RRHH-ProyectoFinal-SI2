<?php

namespace App\Http\Controllers;

use App\Models\PagoEmpleado;
use App\Models\LocationRecord;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class SalarioController extends Controller
{
    // Index: mostrar todos los trabajadores
    public function index()
    {
        $empleados = User::with('pagos')->get();

        return view('pagos.index', compact('empleados'));
    }
    // Mostrar todos los pagos de un empleado agrupados por mes
    public function showEmpleado(User $empleado)
    {
        // Traemos los pagos del empleado
        $pagosPorMes = PagoEmpleado::where('empleado_id', $empleado->id)
            ->orderBy('periodo_inicio', 'desc') // usar periodo_inicio en vez de mes
            ->get()
            ->groupBy(function ($pago) {
                // Agrupamos por año-mes del periodo_inicio
                return Carbon::parse($pago->periodo_inicio)->format('Y-m');
            });

        return view('pagos.empleado', compact('empleado', 'pagosPorMes'));
    }


    public function showMes(User $empleado, $mes)
    {
        // Filtrar pagos del mes
        $pagoMes = PagoEmpleado::where('empleado_id', $empleado->id)
            ->whereMonth('periodo_inicio', '=', Carbon::parse($mes)->month)
            ->whereYear('periodo_inicio', '=', Carbon::parse($mes)->year)
            ->first();

        // Usar nombre completo si existe, sino fallback al name
        $empleadoNombre = $empleado->nombre_completo ?? $empleado->name;
        //dd($empleadoNombre);
        // Traer registros de asistencia del mes desde location_records
        $asistencias = LocationRecord::where('name', $empleadoNombre)
            ->whereMonth('recorded_at', Carbon::parse($mes)->month)
            ->whereYear('recorded_at', Carbon::parse($mes)->year)
            ->orderBy('recorded_at')
            ->get()
            ->groupBy(function ($registro) {
                return Carbon::parse($registro->recorded_at)->format('Y-m-d'); // agrupa por día
            });

        return view('pagos.empleado_mes', compact('empleado', 'pagoMes', 'asistencias', 'mes'));
    }
    // Mostrar formulario para crear nuevo pago
    public function create()
    {
        $empleados = User::all(); // lista de empleados para seleccionar
        return view('pagos.create', compact('empleados'));
    }

    // Guardar nuevo pago
    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:users,id',
            'salario_base' => 'required|numeric|min:0',
            'total_bonos' => 'nullable|numeric|min:0',
            'total_descuentos' => 'nullable|numeric|min:0',
        ]);

        $requestData = $request->all();
        $requestData['total_neto'] = $requestData['salario_base'] + ($requestData['total_bonos'] ?? 0) - ($requestData['total_descuentos'] ?? 0);

        PagoEmpleado::create($requestData);

        return redirect()->route('pagos.index')
            ->with('success', 'Pago registrado correctamente.');
    }

    // Editar pago
    public function edit(PagoEmpleado $pago)
    {
        $empleados = User::all();
        return view('pagos.edit', compact('pago', 'empleados'));
    }

    // Actualizar pago
    public function update(Request $request, PagoEmpleado $pago)
    {
        $request->validate([
            'empleado_id' => 'required|exists:users,id',
            'salario_base' => 'required|numeric|min:0',
            'total_bonos' => 'nullable|numeric|min:0',
            'total_descuentos' => 'nullable|numeric|min:0',
        ]);

        $requestData = $request->all();
        $requestData['total_neto'] = $requestData['salario_base'] + ($requestData['total_bonos'] ?? 0) - ($requestData['total_descuentos'] ?? 0);

        $pago->update($requestData);

        return redirect()->route('pagos.index')
            ->with('success', 'Pago actualizado correctamente.');
    }

    // Eliminar pago
    public function destroy(PagoEmpleado $pago)
    {
        $pago->delete();

        return redirect()->route('pagos.index')
            ->with('success', 'Pago eliminado correctamente.');
    }
}
