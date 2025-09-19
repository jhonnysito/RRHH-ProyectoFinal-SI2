<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $departamentos = Departamento::all();
        return view('departamentos.index', compact('departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('departamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required|unique:departamentos,nombre|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Departamento::create($request->all());

        return redirect()->route('departamentos.index')
                         ->with('success', 'Departamento creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departamento $departamento)
    {
        return view('departamentos.edit', compact('departamento'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Departamento $departamento)
{
    $request->validate([
        'nombre' => 'required|max:255|unique:departamentos,nombre,' . $departamento->id,
        'descripcion' => 'nullable|string',
    ]);

    $departamento->update($request->only(['nombre', 'descripcion']));

    return redirect()->route('departamentos.index')
                     ->with('success', '✏️ Departamento actualizado correctamente.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departamento $departamento)
    {
        $departamento->delete();

        return redirect()->route('departamentos.index')
                         ->with('success', '🗑️ Departamento eliminado correctamente.');
    }
}
