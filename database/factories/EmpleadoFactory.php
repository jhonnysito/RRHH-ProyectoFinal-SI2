<?php

namespace Database\Factories;

use App\Models\Empleado;
use App\Models\Cargo;
use App\Models\Departamento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class EmpleadoFactory extends Factory
{
    protected $model = Empleado::class;

    public function definition()
    {
        // Extensiones de CI de Bolivia
        $extensiones = ['LP', 'CB', 'SC', 'OR', 'PT', 'TJ', 'CH', 'BE', 'PD'];

        // Nombres típicos bolivianos
        $nombres = [
            'Juan Pérez', 'María López', 'Carlos Mamani', 'Ana Quispe',
            'Luis Fernández', 'José Choque', 'Elena Vargas', 'Miguel Álvarez',
            'Sofía Rojas', 'Jhonny Condori', 'Paola Gutiérrez'
        ];

        // Direcciones bolivianas
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

        // Teléfonos móviles bolivianos válidos (6, 7, 3)
        $telefono = '7' . $this->faker->numerify('######');

        return [
            'tenant_id'        => 'empresa1',
            'nombre_completo'  => $this->faker->unique()->randomElement($nombres),

            // CI con extensión típica: 12345678 LP
            'ci'               => $this->faker->numerify('########') . ' ' . $this->faker->randomElement($extensiones),

            'password'         => Hash::make('password123'),

            'cargo_id'         => Cargo::inRandomOrder()->first()->id ?? 1,
            'departamento_id'  => Departamento::inRandomOrder()->first()->id ?? 1,

            // Direcciones bolivianas
            'direccion'        => $this->faker->randomElement($calles) . ' # ' . $this->faker->numerify('###'),

            // Celular boliviano
            'telefono'         => $telefono,

            // Correos simples
            'correo'           => $this->faker->unique()->safeEmail(),

            'estado'           => $this->faker->randomElement(['Activo', 'Inactivo']),

            'user_id'          => User::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
