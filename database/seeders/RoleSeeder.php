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
    public function run()
    {
        $rol1 = Role::create(['name' => 'Administrador']);
         $rol2 = Role::create(['name' => 'Encargado']);
        $rol3 = Role::create(['name' => 'Postulante']);
        $rol4 = Role::create(['name' => 'Empleado']);
     
    //Usuarios y Contratos
        Permission::create(['name' => 'Inicio Empleados'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Crear Empleados'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Guardar Empleados'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Eliminar Empleados'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Editar Empleados'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Actualizar Empleados'])->syncRoles([$rol1, $rol2]);

        Permission::create(['name' => 'Crear Contrato'])->syncRoles([$rol1]);
        Permission::create(['name' => 'Ver Contrato'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Ver Empleado'])->syncRoles([$rol1, $rol2]);

        Permission::create(['name' => 'Asignar Horarios'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Asignar Horarios a Empleado'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Editar Horarios de Empleado'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Eliminar Horarios de Empleado'])->syncRoles([$rol1, $rol2]);

        //roles
        Permission::create(['name' => 'Inicio Roles'])->syncRoles([$rol1]);
        Permission::create(['name' => 'Crear Rol'])->syncRoles([$rol1]);
        Permission::create(['name' => 'Guardar Rol'])->syncRoles([$rol1]);
        Permission::create(['name' => 'Editar Rol'])->syncRoles([$rol1]);
        Permission::create(['name' => 'Actualizar Rol'])->syncRoles([$rol1]);
        Permission::create(['name' => 'Eliminar Rol'])->syncRoles([$rol1]);
    
          //postulantes
        Permission::create(['name' => 'Inicio Postulantes'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Postularse'])->syncRoles([$rol1, $rol3]);
        Permission::create(['name' => 'Guardar Solicitud'])->syncRoles([$rol1, $rol3]);
        Permission::create(['name' => 'Avanzar en Solicitud'])->syncRoles([$rol1, $rol3]);
        Permission::create(['name' => 'Registrar Postulante'])->syncRoles([$rol1, $rol3]);
        Permission::create(['name' => 'Eliminar Postulante'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Editar Solicitud'])->syncRoles([$rol1, $rol2, $rol3]);
        Permission::create(['name' => 'Actualizar Solicitud'])->syncRoles([$rol1, $rol2, $rol3]);

        //Puestos Disponibles
        Permission::create(['name' => 'Inicio Puestos Disponibles'])->syncRoles([$rol1, $rol2, $rol4]);
        Permission::create(['name' => 'Crear Puestos Disponibles'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Guardar Puestos Disponibles'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Eliminar Puestos Disponibles'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Editar Puestos Disponibles'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Actualizar Puestos Disponibles'])->syncRoles([$rol1, $rol2]);

        //Departamentos
        Permission::create(['name' => 'Inicio Departamentos'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Crear Departamentos'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Guardar Departamentos'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Editar Departamentos'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Actualizar Departamentos'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Eliminar Departamentos'])->syncRoles([$rol1, $rol2]);

        //Cargos
        Permission::create(['name' => 'Inicio Cargos'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Crear Cargos'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Guardar Cargos'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Editar Cargos'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Actualizar Cargos'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Eliminar Cargos'])->syncRoles([$rol1, $rol2]);

        //Informacion Personal
        Permission::create(['name' => 'Inicio Informacion Personal'])->syncRoles([$rol1, $rol2, $rol4]);

        //Bitacora
        Permission::create(['name' => 'Inicio Bitacoras'])->syncRoles([$rol1]);
        Permission::create(['name' => 'Inicio Detalles Bitacoras'])->syncRoles([$rol1]);

        Permission::create(['name' => 'Inicio Reportes'])->syncRoles([$rol1, $rol2]);


        //Horarios
        Permission::create(['name' => 'Inicio Horarios'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Crear Horarios'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Guardar Horarios'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Editar Horarios'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Actualizar Horarios'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Eliminar Horarios'])->syncRoles([$rol1, $rol2]);

        Permission::create(['name' => 'Solicitar Permiso'])->syncRoles([$rol4, $rol2]); // Solo los empleados pueden solicitar permisos
        Permission::create(['name' => 'Ver Historial de Permisos'])->syncRoles([$rol1, $rol4, $rol2]); // Solo los administradores pueden ver el historial de permisos

        //ASISTENCIA
        Permission::create(['name' => 'Marcar Asistencia'])->syncRoles([$rol1, $rol2, $rol4]);
        Permission::create(['name' => 'Ver Evaluacion'])->syncRoles([$rol1, $rol2]);

         // Actividades
         Permission::create(['name' => 'Inicio Actividades'])->syncRoles([$rol1, $rol2]);
         Permission::create(['name' => 'Crear Actividades'])->syncRoles([$rol1, $rol2]);
         Permission::create(['name' => 'Guardar Actividades'])->syncRoles([$rol1, $rol2]);
         Permission::create(['name' => 'Editar Actividades'])->syncRoles([$rol1, $rol2]);
         Permission::create(['name' => 'Actualizar Actividades'])->syncRoles([$rol1, $rol2]);
         Permission::create(['name' => 'Eliminar Actividades'])->syncRoles([$rol1, $rol2]);
         
        // Depósitos
        Permission::create(['name' => 'Ver Todos los Depósitos'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Ver Mis Depósitos'])->syncRoles([$rol4]);
        Permission::create(['name' => 'Crear Depósitos'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Editar Depósitos'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Eliminar Depósitos'])->syncRoles([$rol1, $rol2]);
        Permission::create(['name' => 'Depositar Dinero'])->syncRoles([$rol1, $rol2]);


        //memorandums
        Permission::create(['name' => 'Crear memorandum'])->syncRoles([$rol1, $rol2]);

    }
}