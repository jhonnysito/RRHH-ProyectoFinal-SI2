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
    public function inicio(){
        $roles = Role::all();
        return (view('roles.inicio', compact('roles')));
    }

    public function crear(){
        $permissions = Permission::all();
        return view('roles.crear', compact('permissions'));
    }

    public function editar($id){
        $rol = Role::find($id);
        $permissions = Permission::all();
        return view('roles.editar', compact('rol', 'permissions'));
    }

    public function actualizar(Request $request, $id){
        $request->validate([
            'name' => 'required|min:4|max:100',
            'permissions' => 'required'
        ]);

        $rol = Role::find($id);
        $rol->name = $request->name;
        $rol->save();
        $rol->permissions()->sync($request->permissions);
        //-----------------------------------------------
        $bitacora_id = session('bitacora_id');

        if ($bitacora_id) {
            $bitacora = Bitacora::find($bitacora_id);
        
            $horaActual = Crypt::encrypt(Carbon::now()->format('H:i:s'));
        
            $bitacora->detalleBitacoras()->create([
                'accion' => Crypt::encrypt('Actualizar Rol'),
                'metodo' => Crypt::encrypt('PUT'), 
                'hora' => $horaActual,
                'tabla' => Crypt::encrypt('roles'), 
                'registroId' => Crypt::encrypt($rol->id),
                'ruta'=> Crypt::encrypt(request()->fullurl()),
            ]);
        }
        //-----------------------------------------------
        return redirect()->route('roles.inicio', $id)->with('actualizado', "Rol Editado Correctamente");
    }

    public function eliminar($id){
        $rol = Role::find($id);
        $rol->delete();
        return redirect()->route('roles.inicio')->with('eliminado', "Rol Eliminado Correctamente");
    }

    public $permisosSeleccionados = [];
    public $name,$filtro;

    public function guardar(Request $request){
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
