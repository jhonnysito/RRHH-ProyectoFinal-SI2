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
            'name' => 'jhonny',        // Nombre del usuario
            'email' => 'jhonny@rrhh.com',     // Email
            'password' => Hash::make('12345'), // Contraseña (encriptada)
        ]);
    }
}

