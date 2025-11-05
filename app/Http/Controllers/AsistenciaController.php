<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $query = Asistencia::with('empleado')
            ->where('tenant_id', Auth::user()->tenant_id);

        // Filtros opcionales
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        if ($request->filled('empleado_id')) {
            $query->where('empleado_id', $request->empleado_id);
        }

        $asistencias = $query->latest()->paginate(10);
        $empleados = Empleado::where('tenant_id', Auth::user()->tenant_id)->get();

        return view('asistencias.index', compact('asistencias', 'empleados'));
    }

    public function create()
    {
        $empleados = Empleado::where('tenant_id', Auth::user()->tenant_id)->get();
        return view('asistencias.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha' => 'required|date',
            'hora_entrada' => 'nullable|date_format:H:i',
            'hora_salida' => 'nullable|date_format:H:i',
            'estado' => 'required|in:Presente,Tarde,Ausente,Permiso',
        ]);

        Asistencia::create([
            'tenant_id' => Auth::user()->tenant_id,
            'empleado_id' => $request->empleado_id,
            'fecha' => $request->fecha,
            'hora_entrada' => $request->hora_entrada,
            'hora_salida' => $request->hora_salida,
            'estado' => $request->estado,
            'observacion' => $request->observacion,
        ]);

        return redirect()->route('asistencias.index')->with('success', 'Asistencia registrada correctamente.');
    }

    public function edit(Asistencia $asistencia)
    {
        $empleados = Empleado::where('tenant_id', Auth::user()->tenant_id)->get();
        return view('asistencias.edit', compact('asistencia', 'empleados'));
    }

    public function update(Request $request, Asistencia $asistencia)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha' => 'required|date',
            'hora_entrada' => 'nullable|date_format:H:i',
            'hora_salida' => 'nullable|date_format:H:i',
            'estado' => 'required|in:Presente,Tarde,Ausente,Permiso',
        ]);

        $asistencia->update($request->all());

        return redirect()->route('asistencias.index')->with('success', 'Asistencia actualizada correctamente.');
    }

    public function destroy(Asistencia $asistencia)
    {
        $asistencia->delete();

        return redirect()->route('asistencias.index')->with('success', 'Asistencia eliminada correctamente.');
    }
}
