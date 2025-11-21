<?php

namespace App\Http\Controllers;

use App\Models\DescuentoEmpleado;
use App\Models\User;
use App\Models\PagoEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DescuentoEmpleadoController extends Controller
{
    /**
     * Mostrar todos los descuentos
     */
    public function index()
    {
        $descuentos = DescuentoEmpleado::with(['empleado', 'pago'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('descuentos.index', compact('descuentos'));
    }

    /**
     * Mostrar formulario para crear un nuevo descuento
     */
    // Formulario para crear descuento
    public function create()
    {
        return view('descuentos.create');
    }

    /**
     * Guardar un nuevo descuento
     */
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0|max:100', // porcentaje
        ]);

        $user = Auth::user(); // Tenant actual
        $empleados = User::where('tenant_id', $user->tenant_id)->get();

        // Guardar el nuevo descuento (solo porcentaje)
        $nuevoDescuento = DescuentoEmpleado::create([
            'tenant_id' => $user->tenant_id,
            'tipo' => $request->tipo,
            'monto' => $request->monto, // guardamos el porcentaje
        ]);

        foreach ($empleados as $empleado) {
            // Obtener último pago pendiente
            $pago = PagoEmpleado::where('empleado_id', $empleado->id)
                ->where('estado', 'pagado')
                ->latest()
                ->first();

            if (!$pago) {
                continue; // Si no hay pago pendiente, saltar
            }

            // Obtener todos los descuentos existentes para este tenant
            $descuentos = DescuentoEmpleado::where('tenant_id', $user->tenant_id)->get();

            // Calcular el total de descuentos reales sumando todos los porcentajes
            $totalDescuentoMonto = 0;
            foreach ($descuentos as $descuento) {
                $totalDescuentoMonto += ($pago->salario_base * $descuento->monto) / 100;
            }

            // Actualizar pago con el total de descuentos
            $pago->total_descuentos = $totalDescuentoMonto;
            $pago->total_neto = $pago->salario_base + $pago->total_bonos - $pago->total_descuentos;
            $pago->save();
        }

        return redirect()->route('descuentos.index')
            ->with('success', 'Descuento aplicado correctamente a todos los empleados.');
    }





    /**
     * Mostrar formulario para editar un descuento existente
     */
    public function edit(DescuentoEmpleado $descuento)
    {
        $empleados = User::all();
        $pagos = PagoEmpleado::all();
        return view('descuentos.edit', compact('descuento', 'empleados', 'pagos'));
    }

    /**
     * Actualizar un descuento existente
     */
    public function update(Request $request, DescuentoEmpleado $descuento)
    {
        $validator = Validator::make($request->all(), [
            'tenant_id' => 'required|string|max:255',
            'empleado_id' => 'required|exists:users,id',
            'pago_id' => 'nullable|exists:pagos_empleados,id',
            'tipo' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'corresponde_a_mes' => 'nullable|date_format:Y-m',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $descuento->update($validator->validated());

        return redirect()->route('descuentos.index')->with('success', 'Descuento actualizado correctamente.');
    }

    /**
     * Eliminar un descuento
     */
    public function destroy(DescuentoEmpleado $descuento)
    {
        $descuento->delete();
        return redirect()->route('descuentos.index')->with('success', 'Descuento eliminado correctamente.');
    }
}
