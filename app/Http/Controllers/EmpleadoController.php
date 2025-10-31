<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Departamento;
use Spatie\Permission\Models\Role;
use App\Models\Cargo;
use App\Models\Contrato;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\Rules\Password;
use App\Models\User;

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
        //dd($request->all());
        // Validamos los campos del formulario
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'ci' => 'required|string|max:20|unique:empleados,ci',
            'password' => ['required', Password::min(8)],
            'cargo_id' => 'required|exists:cargos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'direccion' => 'nullable|string|max:200',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:100|unique:empleados,correo',
            'estado' => 'required|in:activo,inactivo',
            'roles' => 'required|array',
            'ruta_imagen_e' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        // 1️⃣ Crear el usuario relacionado
        $user = User::create([
            'name' => $request['nombre_completo'],
            'email' => $request['correo'],
            'password' => Hash::make($request['password']),
            'tenant_id' => tenant('id'),
        ]);

        $imagePath = null;
        if ($request->hasFile('ruta_imagen_e')) {
            // Guarda la imagen en 'storage/app/public/fotos_empleados'
            $imagePath = $request->file('ruta_imagen_e')->store('fotos_empleados', 'public');
        }

        // $data['tenant_id'] = auth()->User()->tenant_id;
        $validated['tenant_id'] = tenant('id');
        // Creamos el empleado
        Empleado::create([
            'nombre_completo' => $validated['nombre_completo'],
            'ci' => $validated['ci'],
            'cargo_id' => $validated['cargo_id'],
            'departamento_id' => $validated['departamento_id'],
            'direccion' => $validated['direccion'] ?? null,
            'telefono' => $validated['telefono'] ?? null,
            'correo' => $validated['correo'],
            'estado' => strtolower($validated['estado']),
            'tenant_id' => tenant('id'),
            'user_id' => $user->id,
        ]);

        return redirect()->route('empleados.index')->with('success', 'Empleado registrado correctamente.');
    }
    /**
     * Muestra el formulario de edición de un empleado.
     */
    public function edit($id)
    {
        $empleado = Empleado::with('usuario', 'cargo', 'departamento')->findOrFail($id);
        $roles = Role::all(); // Si usas spatie/laravel-permission
        $departamentos = Departamento::all();
        $cargos = Cargo::all();

        return view('empleados.editar', compact('empleado', 'roles', 'departamentos', 'cargos'));
    }
    public function ver($empleado_id)
    {
        // Buscar el empleado
        $empleado = Empleado::find($empleado_id);

        if (!$empleado) {
            abort(404, 'Empleado no encontrado');
        }

        // Buscar el contrato asociado a ese empleado
        $contrato = Contrato::where('empleado_id', $empleado_id)->first();

        if (!$contrato) {
            abort(404, 'Contrato no encontrado para este empleado');
        }

        // Retornar la vista con los datos
        return view('empleados.ver_contrato', compact('empleado', 'contrato'));
    }
    /**
     * Actualiza un empleado existente.
     */
    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'roles' => 'required|array',
            'ci' => 'required|string|max:20|unique:empleado,ci,' . $empleado->id,
            'cargo_id' => 'required|exists:cargos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'direccion' => 'nullable|string|max:200',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:100|unique:empleados,correo',
            'estado' => 'required|in:activo,inactivo',
            'ruta_imagen_e' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => ['required', Password::min(8)],
        ]);

        // Actualizamos usuario vinculado
        $empleado->usuario->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $empleado->usuario->password,

        ]);

        //Actualizar empleado
        $empleado->update([
            'direccion' => $validated['direccion'] ?? null,
            'telefono' => $validated['telefono'] ?? null,
            'ci' => $validated['ci'],
            'cargo_id' => $validated['cargo_id'],
            'departamento_id' => $validated['departamento_id'],
            'nombre_completo' => $validated['nombre_completo'],
            'correo' => $validated['correo'],
            'estado' => strtolower($validated['estado']),

        ]);

        //  Actualizar roles
        $empleado->usuario->syncRoles($validated['roles']);

        // Imagen
        if ($request->hasFile('ruta_imagen_e')) {
            $imagePath = $request->file('ruta_imagen_e')->store('fotos_empleados', 'public');
            $empleado->update(['ruta_imagen_e' => $imagePath]);
        }

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    /**
     * Elimina un empleado.
     */
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        if ($empleado->usuario) {
            $empleado->usuario->delete();
        }

        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }
    public function info($id)
    {
        $empleado = Empleado::with(['departamento', 'cargo', 'usuario'])->findOrFail($id);
        return view('empleados.info', compact('empleado'));
    }
}
