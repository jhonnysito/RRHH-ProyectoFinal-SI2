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
         User::create([
            'tenant_id' => null,
            'name' => 'SuperAdmin',        // Nombre del usuario
            'email' => 'SuperAdmin@gmail.com',     // Email
            'password' => Hash::make('12345678'), // Contraseña (encriptada)
        ])->assignRole('SuperAdmin');


          User::create([
            'tenant_id' => 'empresa1',
            'name' => 'admin',        // Nombre del usuario
            'email' => 'admin@gmail.com',     // Email
            'password' => Hash::make('12345678'), // Contraseña (encriptada)
        ])->assignRole('Admin');

      
    }
}
