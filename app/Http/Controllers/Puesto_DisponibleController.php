<?php

namespace App\Http\Controllers;

use App\Models\Postulante;
use App\Models\User;
use App\Models\Puesto_Disponible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Puesto_DisponibleController extends Controller
{
    public function inicio()
    {
        $puesto_disponibles = Puesto_Disponible::all();
        return view('puesto_disponibles.inicio', compact('puesto_disponibles'));
    }

    public function crear()
    {
        return view('puesto_disponibles.crear');
    }

    public function guardar(Request $request)
    {
        // ✅ 1️⃣ Validación de los campos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'requisitos' => 'required|string',
            'tipo_contrato' => 'required|string|max:255',
            'modalidad' => 'nullable|string|max:255',
            'nivel' => 'nullable|string|max:255',
            'salario' => 'nullable|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'vacantes' => 'required|integer|min:1',
            'fecha_limite' => 'required|date|after:today',
            'estado' => 'required|in:Activo,Inactivo',
            'beneficios' => 'nullable|string',
        ]);

        // ✅ 2️⃣ Crear el registro del puesto
        $puesto = new Puesto_Disponible();
        $puesto->nombre = $request->nombre;
        $puesto->area = $request->area;
        $puesto->descripcion = $request->descripcion;
        $puesto->requisitos = $request->requisitos;
        $puesto->tipo_contrato = $request->tipo_contrato;
        $puesto->modalidad = $request->modalidad;
        $puesto->nivel = $request->nivel;
        $puesto->salario = $request->salario;
        $puesto->ubicacion = $request->ubicacion;
        $puesto->vacantes = $request->vacantes;
        $puesto->fecha_limite = $request->fecha_limite;
        $puesto->estado = $request->estado;
        $puesto->beneficios = $request->beneficios;

        // ✅ 3️⃣ Asignar tenant_id (soporte multi-tenant)
        if (function_exists('tenant') && tenant()) {
            // Si usas Tenancy for Laravel
            $puesto->tenant_id = tenant('id');
        } else {
            // Si no usas Tenancy, lo tomamos del usuario autenticado
            $puesto->tenant_id = auth()->user()->tenant_id;
        }

        // ✅ 4️⃣ Guardar el registro
        $puesto->save();

        // ✅ 5️⃣ Redirigir con mensaje de éxito
        return redirect()
            ->route('puesto_disponibles.inicio')
            ->with('creado', '✅ Puesto disponible creado exitosamente.');
    }


    public function editar($id)
    {
        $puesto_disponibles = Puesto_Disponible::where('id', '=', $id)->first();
        return view('puesto_disponibles.editar', compact('puesto_disponibles'));
    }

    public function actualizar(Request $request, $id)
    {
        // ✅ 1️⃣ Validación de los campos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'requisitos' => 'required|string',
            'tipo_contrato' => 'required|string|max:255',
            'modalidad' => 'nullable|string|max:255',
            'nivel' => 'nullable|string|max:255',
            'salario' => 'nullable|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'vacantes' => 'required|integer|min:1',
            'fecha_limite' => 'required|date|after:today',
            'estado' => 'required|in:Activo,Inactivo',
            'beneficios' => 'nullable|string',
        ]);

        // ✅ 2️⃣ Buscar el registro existente
        $puesto = Puesto_Disponible::findOrFail($id);

        // ✅ 3️⃣ Actualizar los campos
        $puesto->nombre = $request->nombre;
        $puesto->area = $request->area;
        $puesto->descripcion = $request->descripcion;
        $puesto->requisitos = $request->requisitos;
        $puesto->tipo_contrato = $request->tipo_contrato;
        $puesto->modalidad = $request->modalidad;
        $puesto->nivel = $request->nivel;
        $puesto->salario = $request->salario;
        $puesto->ubicacion = $request->ubicacion;
        $puesto->vacantes = $request->vacantes;
        $puesto->fecha_limite = $request->fecha_limite;
        $puesto->estado = $request->estado;
        $puesto->beneficios = $request->beneficios;

        // ✅ 4️⃣ Mantener tenant_id igual que estaba (no cambiamos)
        // Esto es opcional si no quieres permitir cambiarlo
        // $puesto->tenant_id = $puesto->tenant_id;

        // ✅ 5️⃣ Guardar los cambios
        $puesto->save();

        // ✅ 6️⃣ Redirigir con mensaje de éxito
        return redirect()
            ->route('puesto_disponibles.inicio')
            ->with('actualizado', '✅ Puesto disponible actualizado exitosamente.');
    }


    public function eliminar($id)
    {
        $puesto_disponibles = Puesto_Disponible::where('id', '=', $id)->first();
        $nombre = $puesto_disponibles->nombre;
        $puesto_disponibles->delete();


        return redirect(route('puesto_disponibles.inicio'))->with('eliminado', 'Puesto_Disponible ' . $nombre . ' eliminado exitosamente');
    }
    public function verDisponiblesEmpresa()
    {
        // Obtener los puestos activos de la empresa (tenant actual)
        $puesto_disponibles = Puesto_Disponible::where('estado', 'Activo')
            ->where('tenant_id', auth()->check() ? auth()->user()->tenant_id : null)
            ->get();

        return view('puesto_disponibles.verPuestosDisponibles', compact('puesto_disponibles'));
    }
    public function disponibles()
    {
        $puesto_disponibles = Puesto_Disponible::where('disponible', '>', 0)->get();
        return view('puesto_disponibles.puestos', compact('puesto_disponibles'));
    }

    public function postularse($idpuesto)
    {
        $id = Auth::user()->id;
        $postulante = Postulante::where('ID_Usuario', '=', $id)->first();
        $postulante->ID_Puesto_Disponible = $idpuesto;
        $postulante->estado = null;
        $postulante->save();
        return redirect(route('puesto_disponibles.disponibles'))->with('actualizado', 'Has pustulado al puesto exitosamente');
    }
}
