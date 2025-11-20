<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Departamento;

class EmpleadoFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Creamos un usuario para este empleado
            'user_id' => User::factory(),
            'nombre_completo' => $this->faker->name(),
            'ci' => $this->faker->unique()->numerify('#######'),
            'telefono' => $this->faker->phoneNumber(),
            'direccion' => $this->faker->address(),
            'correo' => $this->faker->unique()->safeEmail(),
            'estado' => $this->faker->randomElement(['activo', 'inactivo']),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '2000-01-01'),
            'genero' => $this->faker->randomElement(['Masculino', 'Femenino']),
            // Asignamos cargo y departamento aleatorios
            'cargo_id' => Cargo::inRandomOrder()->first()->id ?? Cargo::factory(),
            'departamento_id' => Departamento::inRandomOrder()->first()->id ?? Departamento::factory(),
            'tenant_id' => 'empresa1',
        ];
    }
}