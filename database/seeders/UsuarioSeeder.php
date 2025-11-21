<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
// --- ¡AJUSTE! Importaciones necesarias ---
use App\Models\Empleado;
use App\Models\Departamento;
use App\Models\Cargo;
// --- FIN AJUSTE ---
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Run the database seeds.
 */
class UsuarioSeeder extends Seeder
{
    public function run(): void
    {

        // Crear usuario SuperAdmin
        $userSuperAdmin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'superadmin',
                'password' => Hash::make('12345678'),
            ]
        );
        $userSuperAdmin->assignRole('SuperAdmin');

        // --- ¡AJUSTE! Crear dependencias (Departamento y Cargo)
        // Esto es OBLIGATORIO o la creación de Empleado fallará
        $depto = Departamento::firstOrCreate(
            ['nombre' => 'Recursos Humanos'],
            ['descripcion' => 'Departamento de RRHH', 'tenant_id' => 'empresa1']
        );
        $cargo = Cargo::firstOrCreate(
            ['nombre' => 'Gerencia', 'departamento_id' => $depto->id],
            ['descripcion' => 'Gerencia de RRHH', 'tenant_id' => 'empresa1']
        );
        // --- FIN AJUSTE ---

        $userAdmin =  User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Evitar error de duplicado
            [
                'tenant_id' => 'empresa1',
                'name' => 'admin',
                'password' => Hash::make('12345678'),
            ]
        );
        $userAdmin->assignRole('Admin');
        //$userAdmin->assignRole('Recursos Humanos'); // <-- ¡AJUSTE PARA EL CHAT!

        // --- ¡AJUSTE OBLIGATORIO! Crear perfil de Empleado ---
        Empleado::firstOrCreate( // Evitar error de duplicado
            ['user_id' => $userAdmin->id],
            [
                'nombre_completo' => $userAdmin->name,
                'correo' => $userAdmin->email,
                'departamento_id' => $depto->id,
                'cargo_id' => $cargo->id,
                'tenant_id' => 'empresa1'
            ]
        );


    }
}