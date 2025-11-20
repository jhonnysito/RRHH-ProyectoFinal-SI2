<?php

namespace Database\Factories;

use App\Models\Puesto;
use Illuminate\Database\Eloquent\Factories\Factory;

class PuestoFactory extends Factory
{
    protected $model = Puesto::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->jobTitle(),
            'descripcion' => $this->faker->paragraph(),
            'vacantes' => $this->faker->numberBetween(1, 10),
            'ubicacion' => $this->faker->city(),
            'tenant_id' => 'empresa1', // <- tenant fijo
        ];
    }
}
