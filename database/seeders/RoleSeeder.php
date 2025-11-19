<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // --- ¡AJUSTE MÍNIMO! ---
        // Cambiamos create() por firstOrCreate()
        // Esto evita el error "Already Exists" si se ejecuta de nuevo.

        $rol1 = Role::firstOrCreate(['name' => 'Administrador']);
        $rol2 = Role::firstOrCreate(['name' => 'Encargado']);
        $rol4 = Role::firstOrCreate(['name' => 'Empleado']);

        // --- ¡AJUSTE NECESARIO PARA EL CHAT! ---
        Role::firstOrCreate(['name' => 'Recursos Humanos']);
        // --- FIN DEL AJUSTE ---
     
        //Usuarios y Contratos
        // --- ¡AJUSTE MÍNIMO! ---
        // Cambiamos create() por firstOrCreate() para que no falle
        Permission::firstOrCreate(['name' => 'Inicio Empleados'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Crear Empleados'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Guardar Empleados'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Eliminar Empleados'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Editar Empleados'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Actualizar Empleados'])->syncRoles([$rol1, $rol2]);

        Permission::firstOrCreate(['name' => 'Crear Contrato'])->syncRoles([$rol1]);
        Permission::firstOrCreate(['name' => 'Ver Contrato'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Ver Empleado'])->syncRoles([$rol1, $rol2]);

        Permission::firstOrCreate(['name' => 'Asignar Horarios'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Asignar Horarios a Empleado'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Editar Horarios de Empleado'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Eliminar Horarios de Empleado'])->syncRoles([$rol1, $rol2]);

        //roles
        Permission::firstOrCreate(['name' => 'Inicio Roles'])->syncRoles([$rol1]);
        Permission::firstOrCreate(['name' => 'Crear Rol'])->syncRoles([$rol1]);
        Permission::firstOrCreate(['name' => 'Guardar Rol'])->syncRoles([$rol1]);
        Permission::firstOrCreate(['name' => 'Editar Rol'])->syncRoles([$rol1]);
        Permission::firstOrCreate(['name' => 'Actualizar Rol'])->syncRoles([$rol1]);
        Permission::firstOrCreate(['name' => 'Eliminar Rol'])->syncRoles([$rol1]);
    
        //postulantes
        Permission::firstOrCreate(['name' => 'Inicio Postulantes'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Postularse'])->syncRoles($rol1);
        Permission::firstOrCreate(['name' => 'Guardar Solicitud'])->syncRoles([$rol1]);
        Permission::firstOrCreate(['name' => 'Avanzar en Solicitud'])->syncRoles([$rol1]);
        Permission::firstOrCreate(['name' => 'Registrar Postulante'])->syncRoles([$rol1]);
        Permission::firstOrCreate(['name' => 'Eliminar Postulante'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Editar Solicitud'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Actualizar Solicitud'])->syncRoles([$rol1, $rol2]);

        //Puestos Disponibles
        Permission::firstOrCreate(['name' => 'Inicio Puestos Disponibles'])->syncRoles([$rol1, $rol2, $rol4]);
        Permission::firstOrCreate(['name' => 'Crear Puestos Disponibles'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Guardar Puestos Disponibles'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Eliminar Puestos Disponibles'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Editar Puestos Disponibles'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Actualizar Puestos Disponibles'])->syncRoles([$rol1, $rol2]);

        //Departamentos
        Permission::firstOrCreate(['name' => 'Inicio Departamentos'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Crear Departamentos'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Guardar Departamentos'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Editar Departamentos'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Actualizar Departamentos'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Eliminar Departamentos'])->syncRoles([$rol1, $rol2]);

        //Cargos
        Permission::firstOrCreate(['name' => 'Inicio Cargos'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Crear Cargos'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Guardar Cargos'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Editar Cargos'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Actualizar Cargos'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Eliminar Cargos'])->syncRoles([$rol1, $rol2]);

        //Informacion Personal
        Permission::firstOrCreate(['name' => 'Inicio Informacion Personal'])->syncRoles([$rol1, $rol2, $rol4]);

        //Bitacora
        Permission::firstOrCreate(['name' => 'Inicio Bitacoras'])->syncRoles([$rol1]);
        Permission::firstOrCreate(['name' => 'Inicio Detalles Bitacoras'])->syncRoles([$rol1]);

        Permission::firstOrCreate(['name' => 'Inicio Reportes'])->syncRoles([$rol1, $rol2]);


        //Horarios
        Permission::firstOrCreate(['name' => 'Inicio Horarios'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Crear Horarios'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Guardar Horarios'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Editar Horarios'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Actualizar Horarios'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Eliminar Horarios'])->syncRoles([$rol1, $rol2]);

        Permission::firstOrCreate(['name' => 'Solicitar Permiso'])->syncRoles([$rol4, $rol2]); // Solo los empleados pueden solicitar permisos
        Permission::firstOrCreate(['name' => 'Ver Historial de Permisos'])->syncRoles([$rol1, $rol4, $rol2]); // Solo los administradores pueden ver el historial de permisos

        //ASISTENCIA
        Permission::firstOrCreate(['name' => 'Marcar Asistencia'])->syncRoles([$rol1, $rol2, $rol4]);
        Permission::firstOrCreate(['name' => 'Ver Evaluacion'])->syncRoles([$rol1, $rol2]);

        // Actividades
        Permission::firstOrCreate(['name' => 'Inicio Actividades'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Crear Actividades'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Guardar Actividades'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Editar Actividades'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Actualizar Actividades'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Eliminar Actividades'])->syncRoles([$rol1, $rol2]);
         
        // Depósitos
        Permission::firstOrCreate(['name' => 'Ver Todos los Depósitos'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Ver Mis Depósitos'])->syncRoles([$rol4]);
        Permission::firstOrCreate(['name' => 'Crear Depósitos'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Editar Depósitos'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Eliminar Depósitos'])->syncRoles([$rol1, $rol2]);
        Permission::firstOrCreate(['name' => 'Depositar Dinero'])->syncRoles([$rol1, $rol2]);


        //memorandums
        Permission::firstOrCreate(['name' => 'Crear memorandum'])->syncRoles([$rol1, $rol2]);
    }
}