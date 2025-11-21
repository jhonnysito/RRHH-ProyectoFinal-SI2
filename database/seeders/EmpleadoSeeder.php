<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Cargo;
use App\Models\Departamento;

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

        $cargos = Cargo::all();
        $departamentos = Departamento::all();

        for ($i = 0; $i < 50; $i++) { // Generar 50 empleados
            // Elegir nombres aleatorios
            $nombre = $nombres[array_rand($nombres)] . ' ' . $apellidos[array_rand($apellidos)];

            // Elegir cargo aleatorio
            $cargo = $cargos->random();
            $departamento = $departamentos->find($cargo->departamento_id);

            // Correo único
            $email = strtolower(str_replace(' ', '.', $nombre)) . $i . '@empresa.com';

            // Crear usuario asociado
            $user = User::create([
                'name' => $nombre,
                'email' => $email,
                'password' => Hash::make('password123'),
                'tenant_id' => 'empresa1',
            ]);

            // CI
            $ci = rand(1000000, 99999999) . ' ' . $extensiones[array_rand($extensiones)];

            // Teléfono y dirección
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
            $telefono = '7' . rand(100000, 999999);

            // Crear empleado
            Empleado::create([
                'tenant_id' => 'empresa1',
                'nombre_completo' => $nombre,
                'correo' => $email,
                'direccion' => $direccion,
                'telefono' => $telefono,
                'ci' => $ci,
                'departamento_id' => $departamento->id,
                'cargo_id' => $cargo->id,
                'user_id' => $user->id,
                'estado' => 'Activo',
            ]);
        }
    }
}
