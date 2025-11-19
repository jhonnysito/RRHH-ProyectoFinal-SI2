<?php

namespace App\Http\Controllers;

use App\Models\DescuentoEmpleado;
use App\Models\User;
use App\Models\PagoEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function create()
    {
        $empleados = User::all(); // O solo los empleados si tienes un scope
        $pagos = PagoEmpleado::all();
        return view('descuentos.create', compact('empleados', 'pagos'));
    }

    /**
     * Guardar un nuevo descuento
     */
    public function store(Request $request)
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

        DescuentoEmpleado::create($validator->validated());

        return redirect()->route('descuentos.index')->with('success', 'Descuento creado correctamente.');
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
