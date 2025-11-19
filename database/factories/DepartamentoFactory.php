<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepartamentoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->jobArea(), // Ej: Marketing, Ventas
            'descripcion' => $this->faker->sentence(),
            'tenant_id' => 'empresa1', // Asumimos un tenant fijo para la demo
        ];
    }
}