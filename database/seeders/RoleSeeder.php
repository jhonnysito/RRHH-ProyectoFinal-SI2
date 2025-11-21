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
        // Definir módulos y acciones
        $permisosPorCu = [
            // Gestión de seguridad y configuración
            'Usuarios' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
            'Roles' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
            'Permisos' => ['Agregar', 'Eliminar', 'Ver'],
            'Bitacoras' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],

            // Recursos Humanos
            'Departamentos' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
            'Puestos Disponibles' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
            'Postulantes' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
            'Cargos' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
            'Entrevistas' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
            'Empleados' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
            'Asistencias' => ['Agregar', 'Editar', 'Eliminar', 'Ver', 'Marcar'],
            'Permisos Laborales' => ['Solicitar', 'Editar', 'Eliminar', 'Ver'],
            'Vacaciones' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
            'Contratos' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
            'Horarios' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
            'Nóminas' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
            'Evaluaciones' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
            'Capacitaciones' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
            'Salarios' => ['Agregar', 'Editar', 'Eliminar', 'Ver'],
        ];

        // Crear todos los permisos
        foreach ($permisosPorCu as $modulo => $acciones) {
            foreach ($acciones as $accion) {
                Permission::firstOrCreate([
                    'name' => "$accion $modulo",
                    'guard_name' => 'web',
                ]);
            }
        }

        // Crear el rol SuperAdmin (si no existe)
        $rolSuperAdmin = Role::firstOrCreate(['name' => 'SuperAdmin', 'guard_name' => 'web']);

        // Asignarle todos los permisos al rol
        $rolSuperAdmin->syncPermissions(Permission::all());

        // 1️⃣ Crear el rol Admin si no existe
        $rolAdmin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);

        // 2️⃣ Asignarle todos los permisos al rol SuperAdmin
        $rolAdmin->syncPermissions(Permission::all());

        // Filtrar permisos que NO quieres darle al Admin
        $permisosAdmin = Permission::all()->reject(function ($permiso) {
            return in_array($permiso->name, ['Agregar Permisos', 'Eliminar Permisos']);
        });

        // Asignarle los permisos filtrados al Admin
        $rolAdmin->syncPermissions($permisosAdmin);
    }
}