<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContratoCreadoMail;

class ContratoController extends Controller
{
    public function create($empleado_id)
    {
        $empleado = Empleado::with(['cargo', 'departamento'])
        ->where('tenant_id', tenant('id'))
        ->findOrFail($empleado_id);
        return view('empleados.contrato', compact('empleado'));
    }

    public function store(Request $request)
    {
        $validated =$request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'sueldo' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'tipo' => 'required|in:Indefinido,anual,Temporal',
            'observaciones' => 'nullable|string',
        ]);
         $tipo = strtolower($validated['tipo']);
        $allowed = ['indefinido', 'anual']; // ajustar si agregas más en la migración
        if (! in_array($tipo, $allowed)) {
        return back()
            ->withInput()
            ->withErrors(['tipo' => 'Tipo de contrato inválido. Seleccione: ' . implode(', ', $allowed)]);
    }
        if ($tipo === 'indefinido') {
        $validated['fecha_fin'] = null;
    }
        $tenant_id = Auth::user()->tenant_id;

        $contrato = Contrato::create([
            'empleado_id' => $request->empleado_id,
            'sueldo' => $request->sueldo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'tipo' => 'anual',
            'observaciones' => $request->observaciones,
            'tenant_id' => $tenant_id,
        ]);

        // Enviar correo al empleado
         $empleado = Empleado::find($validated['empleado_id']);
        if ($empleado && $empleado->correo) {
            Mail::to($empleado->correo)->send(new ContratoCreadoMail($empleado, $contrato));
        }

        return redirect()->route('empleados.index')->with('success', 'Contrato creado y enviado al correo del empleado.');
    }

    public function ver($empleado_id)
    {
         $empleado = Empleado::with(['cargo', 'departamento', 'contratos'])
        ->findOrFail($empleado_id);
        return view('empleados.ver_contrato', compact('empleado'));
    }
}
