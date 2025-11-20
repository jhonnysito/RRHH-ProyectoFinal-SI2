<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empleado;
use App\Models\Departamento;
use App\Models\Cargo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmpleadoSeeder extends Seeder
{
    public function run()
    {
        // Lista de nombres y apellidos típicos bolivianos
        $nombres = [
            'Juan', 'María', 'Carlos', 'Ana', 'Luis', 'José', 'Elena',
            'Miguel', 'Sofía', 'Jhonny', 'Paola', 'Fernando', 'Lucía'
        ];

        $apellidos = [
            'Pérez', 'López', 'Mamani', 'Quispe', 'Fernández', 'Choque',
            'Vargas', 'Álvarez', 'Rojas', 'Condori', 'Gutiérrez', 'Cruz'
        ];

        // Extensiones típicas de CI en Bolivia
        $extensiones = ['LP', 'CB', 'SC', 'OR', 'PT', 'TJ', 'CH', 'BE', 'PD'];

        // Obtener todos los cargos existentes
        $cargos = Cargo::all();
        $departamentos = Departamento::all();
        $users = User::all();

        for ($i = 0; $i < 100; $i++) {
            // Elegir nombres aleatorios
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)];

            // Elegir cargo aleatorio
            $cargo = $cargos->random();

            // Dirección boliviana
            $calles = [
                'Av. Mariscal Santa Cruz',
                'Av. Busch',
                'Av. Cristo Redentor',
                'Av. América',
                'Av. Beni',
                'Calle Sucre',
                'Calle Cochabamba',
                'Calle Junín',
                'Av. El Prado',
                'Av. Blanco Galindo',
            ];
            $direccion = $calles[array_rand($calles)] . ' # ' . rand(1, 500);

            // Teléfono celular boliviano (7 dígitos)
            $telefono = '7' . rand(100000, 999999);

            // Correo
             $correo = strtolower(str_replace(' ', '.', $nombre)) . $i . '@empresa.com'; // <- asegura unicidad

            // CI
            $ci = rand(1000000, 99999999) . ' ' . $extensiones[array_rand($extensiones)];

            // Usuario asignado (aleatorio)
            $user = $users->random();

            Empleado::create([
                'tenant_id'       => 'empresa1',
                'nombre_completo' => $nombre,
                'correo'          => $correo,
                'direccion'       => $direccion,
                'telefono'        => $telefono,
                'ci'              => $ci,
                'departamento_id' => $cargo->departamento_id,
                'cargo_id'        => $cargo->id,
                'user_id'         => $user->id,
                'password'        => Hash::make('password123'),
                'estado'          => rand(0,1) ? 'Activo' : 'Inactivo',
            ]);
        }
    }
}
