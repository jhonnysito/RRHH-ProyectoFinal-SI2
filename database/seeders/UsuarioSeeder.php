<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Run the database seeds.
 */
class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $user =  User::create([
            'tenant_id' => 'empresa1',
            'name' => 'admin',        // Nombre del usuario
            'email' => 'admin@gmail.com',     // Email
            'password' => Hash::make('12345678'), // Contraseña (encriptada)
        ])->assignRole('Administrador');


        $user =  User::create([
            'tenant_id' => 'empresa1',
            'name' => 'empleado',        // Nombre del usuario
            'email' => 'empleado@gmail.com',     // Email
            'password' => Hash::make('12345678'), // Contraseña (encriptada)
        ])->assignRole('Empleado');


        $user =  User::create([
            'tenant_id' => 'empresa1',
            'name' => 'encargado',        // Nombre del usuario
            'email' => 'encargado@gmail.com',     // Email
            'password' => Hash::make('12345678'), // Contraseña (encriptada)
        ])->assignRole('Encargado');
    }
}