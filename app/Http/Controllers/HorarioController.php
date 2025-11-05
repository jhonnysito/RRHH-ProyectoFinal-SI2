<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HorarioController extends Controller
{
    /**
     * Mostrar la lista de horarios (solo del tenant actual), ordenados Lunes→Domingo.
     */
    public function index(Request $request)
    {
        $tenantId = Auth::user()->tenant_id;

        // Orden fijo de días de la semana
        $ordenDias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];

        // Base query
        $query = Horario::with('empleado')
            ->where('tenant_id', $tenantId);

        // Filtro de búsqueda
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('empleado', function ($q) use ($search) {
                $q->where('nombre_completo', 'like', "%{$search}%");
            });
        }

        // Obtener resultados y ordenar según el día de la semana
        $horarios = $query->get()
            ->sortBy(fn($h) => array_search($h->dia_semana, $ordenDias));

        return view('horarios.index', compact('horarios'));
    }


    /**
     * Mostrar formulario de creación de horario.
     */
    public function create()
    {
        $tenantId = Auth::user()->tenant_id;
        $empleados = Empleado::where('tenant_id', $tenantId)->get();

        return view('horarios.create', compact('empleados'));
    }

    /**
     * Guardar un nuevo horario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'dia_semana' => [
                'required',
                'string',
                function($attribute, $value, $fail) use ($request) {
                    $exists = Horario::where('empleado_id', $request->empleado_id)
                        ->where('dia_semana', $value)
                        ->where('tenant_id', Auth::user()->tenant_id)
                        ->exists();
                    if ($exists) {
                        $fail('El empleado ya tiene un horario asignado para ese día.');
                    }
                }
            ],
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i|after:hora_entrada',
        ]);

        Horario::create([
            'tenant_id' => Auth::user()->tenant_id,
            'empleado_id' => $request->empleado_id,
            'dia_semana' => $request->dia_semana,
            'hora_entrada' => $request->hora_entrada,
            'hora_salida' => $request->hora_salida,
        ]);

        return redirect()->route('horarios.index')->with('success', 'Horario registrado correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Horario $horario)
    {
        $this->authorizeTenant($horario);

        $tenantId = Auth::user()->tenant_id;
        $empleados = Empleado::where('tenant_id', $tenantId)->get();

        return view('horarios.edit', compact('horario', 'empleados'));
    }

    /**
     * Actualizar un horario.
     */
    public function update(Request $request, Horario $horario)
    {
        $this->authorizeTenant($horario);

        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'dia_semana' => [
                'required',
                'string',
                function($attribute, $value, $fail) use ($request, $horario) {
                    $exists = Horario::where('empleado_id', $request->empleado_id)
                        ->where('dia_semana', $value)
                        ->where('tenant_id', Auth::user()->tenant_id)
                        ->where('id', '!=', $horario->id)
                        ->exists();
                    if ($exists) {
                        $fail('El empleado ya tiene un horario asignado para ese día.');
                    }
                }
            ],
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i|after:hora_entrada',
        ]);

        $horario->update([
            'empleado_id' => $request->empleado_id,
            'dia_semana' => $request->dia_semana,
            'hora_entrada' => $request->hora_entrada,
            'hora_salida' => $request->hora_salida,
        ]);

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado correctamente.');
    }

    /**
     * Eliminar un horario.
     */
    public function destroy(Horario $horario)
    {
        $this->authorizeTenant($horario);

        $horario->delete();

        return redirect()->route('horarios.index')->with('success', 'Horario eliminado correctamente.');
    }

    /**
     * Verifica que el horario pertenezca al tenant actual.
     */
    private function authorizeTenant(Horario $horario)
    {
        if ($horario->tenant_id !== Auth::user()->tenant_id) {
            abort(403, 'No autorizado');
        }
    }
}
