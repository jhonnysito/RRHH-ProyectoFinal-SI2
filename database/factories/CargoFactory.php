<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Departamento;

class CargoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->jobTitle(), // Ej: Senior Developer
            'descripcion' => $this->faker->sentence(),
            // Asignamos un departamento aleatorio que ya exista
            'ID_Departamento' => Departamento::inRandomOrder()->first()->id ?? Departamento::factory(),
            'tenant_id' => 'empresa1',
        ];
    }
}