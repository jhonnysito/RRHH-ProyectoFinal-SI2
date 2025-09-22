<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;

use App\Models\Departamento;

class CargoController extends Controller
{
    public function index()
    {
        //$cargos = Cargo::all();
        $cargos = Cargo::with('departamento')->get();

        return view('cargos.index', compact('cargos'));
    }

    public function create()
    {
        $departamentos = Departamento::all(); // para el select
        return view('cargos.create', compact('departamentos'));
    

    }

    
    // Guardar nuevo cargo
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:cargos,nombre|max:255',
            'descripcion' => 'nullable|string',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);

        Cargo::create($request->only(['nombre', 'descripcion', 'departamento_id']));

        return redirect()->route('cargos.index')
                         ->with('success', '✅ Cargo creado correctamente.');
    }

    public function edit(Cargo $cargo)
    {
        $departamentos = Departamento::all();
        return view('cargos.edit', compact('cargo', 'departamentos'));
    }
/*
    public function update(Request $request, Cargo $cargo)
    {
        $request->validate([
            'nombre' => 'required|max:255|unique:cargos,nombre,' . $cargo->id,
            'descripcion' => 'nullable|string',
        ]);

        $cargo->update($request->only(['nombre', 'descripcion']));

        return redirect()->route('cargos.index')
                         ->with('success', '✏️ Cargo actualizado correctamente.');
    }*/
    // Actualizar cargo existente
    public function update(Request $request, Cargo $cargo)
    {
        $request->validate([
            'nombre' => 'required|max:255|unique:cargos,nombre,' . $cargo->id,
            'descripcion' => 'nullable|string',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);

        $cargo->update($request->only(['nombre', 'descripcion', 'departamento_id']));

        return redirect()->route('cargos.index')
                         ->with('success', '✏️ Cargo actualizado correctamente.');
    }

    public function destroy(Cargo $cargo)
    {
        $cargo->delete();

        return redirect()->route('cargos.index')
                         ->with('success', '🗑️ Cargo eliminado correctamente.');
    }
}