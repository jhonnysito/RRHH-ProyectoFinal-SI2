<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * Run the database seeds.
 */
class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'admin',        // Nombre del usuario
            'email' => 'admin@gmail.com',     // Email
            'password' => Hash::make('12345678'), // Contraseña (encriptada)
        ]);
    }
}
