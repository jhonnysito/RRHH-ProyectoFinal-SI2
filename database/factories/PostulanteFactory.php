<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostulanteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombres' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'experiencia_anios' => $this->faker->numberBetween(0, 10),
            'skills' => $this->faker->words(3, true), // Ej: "php laravel react"
            'estado' => 'pendiente',
            'tenant_id' => 'empresa1',
        ];
    }
}