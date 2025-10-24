<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado; 
use App\Models\Departamento; 
use Spatie\Permission\Models\Role;
use App\Models\Cargo; 

class EmpleadoController extends Controller

{
    /**
     * Muestra la lista de empleados con filtros y búsqueda.
     */
    public function index(Request $request)
    {
        // Obtenemos los parámetros enviados por el formulario de filtros
        $empleados = Empleado::with('usuario')->get();
        $buscar = $request->input('buscar');
        $departamento = $request->input('departamento');
        $estado = $request->input('estado');

        // Construimos la consulta base
        $query = Empleado::query();

        // Filtro por nombre o apellido (búsqueda general)
        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('apellido', 'LIKE', "%{$buscar}%")
                  ->orWhere('ci', 'LIKE', "%{$buscar}%");
            });
        }

        // Filtro por departamento (si aplica)
        if ($departamento) {
            $query->where('departamento', $departamento);
        }

        // Filtro por estado (activo/inactivo)
        if ($estado) {
            $query->where('estado', $estado);
        }

        // Ordenamos por fecha de creación y paginamos resultados
        $empleados = $query->orderBy('created_at', 'desc')->paginate(10);

        // Pasamos datos a la vista
        return view('empleados.empleado', [
            'empleados' => $empleados,
            'buscar' => $buscar,
            'departamento' => $departamento,
            'estado' => $estado,
        ]);
    }

    /**
     * Muestra el formulario para registrar un nuevo empleado.
     */
    public function create()
    {
    $departamentos = Departamento::all();
    $roles = Role::all();
    $cargos = Cargo::all();

    return view('empleados.crear', compact('departamentos', 'roles', 'cargos'));
    }

    /**
     * Guarda un nuevo empleado en la base de datos.
     */
        public function store(Request $request)
    {
        // Validamos los campos del formulario
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'ci' => 'required|string|max:20|unique:empleados,ci',
            //'ci' => 'required|string|max:20',
            'cargo_id' => 'required|exists:cargos,id', 
            'departamento_id' => 'required|exists:departamentos,id', 
            'direccion' => 'nullable|string|max:200',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:100|unique:empleados,correo', 
            'estado' => 'required|in:activo,inactivo',
        ]);


        $validated['tenant_id'] = tenant('id');
        // Creamos el empleado
        Empleado::create($validated);

        return redirect()->route('empleados.index')->with('success', 'Empleado registrado correctamente.');
    }
    /**
     * Muestra el formulario de edición de un empleado.
     */
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('admin.empleado_edit', compact('empleado'));
    }

    /**
     * Actualiza un empleado existente.
     */
    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'ci' => 'required|string|max:20|unique:empleado,ci,' . $empleado->id,
            'cargo' => 'required|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'direccion' => 'nullable|string|max:200',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $empleado->update($validated);

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    /**
     * Elimina un empleado.
     */
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }
}
