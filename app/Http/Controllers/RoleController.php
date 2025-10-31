<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function inicio()
    {
        $roles = Role::all();
        return (view('roles.inicio', compact('roles')));
    }

    public function crear()
    {
        $permissions = Permission::all();
        return view('roles.crear', compact('permissions'));
    }

    public function editar()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('roles.editar', compact('roles', 'permissions'));
    }

    public function actualizar(Request $request)
    {
        // Validar que venga algún rol y permisos
        $request->validate([
            'roles' => 'required|array',
        ]);

        $bitacora_id = session('bitacora_id');

        foreach ($request->roles as $rolId => $rolData) {
            $rol = Role::find($rolId);

            if (!$rol) continue; // saltar si no existe

            // Validar campos individuales
            $validated = \Validator::make($rolData, [
                'name' => 'required|min:4|max:100',
                'permissions' => 'nullable|array',
            ])->validate();

            // Actualizar nombre
            $rol->name = $validated['name'];
            $rol->save();

            // Sincronizar permisos (si viene algo)
            $rol->permissions()->sync($validated['permissions'] ?? []);

            // Registrar en bitacora
            if ($bitacora_id) {
                $bitacora = Bitacora::find($bitacora_id);
                if ($bitacora) {
                    $horaActual = Crypt::encrypt(\Carbon\Carbon::now()->format('H:i:s'));

                    $bitacora->detalleBitacoras()->create([
                        'accion' => Crypt::encrypt('Actualizar Rol'),
                        'metodo' => Crypt::encrypt('PUT'),
                        'hora' => $horaActual,
                        'tabla' => Crypt::encrypt('roles'),
                        'registroId' => Crypt::encrypt($rol->id),
                        'ruta' => Crypt::encrypt(request()->fullUrl()),
                    ]);
                }
            }
        }

        return redirect()->route('roles.inicio')->with('actualizado', "Roles editados correctamente");
    }

    public function eliminar($id)
    {
        $rol = Role::find($id);
        $rol->delete();
        return redirect()->route('roles.inicio')->with('eliminado', "Rol Eliminado Correctamente");
    }

    public $permisosSeleccionados = [];
    public $name, $filtro;

    public function guardar(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4|max:100|unique:roles',
            'permissions' => 'required'
        ]);

        $rol = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        $rol->permissions()->sync($request->permissions);

        return redirect()->route('roles.inicio')->with('creado', "Rol Creado Correctamente");
    }
}
