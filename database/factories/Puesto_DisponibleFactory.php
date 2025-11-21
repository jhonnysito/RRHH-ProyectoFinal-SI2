<?php

namespace Database\Factories;

use App\Models\Puesto_Disponible;
use Illuminate\Database\Eloquent\Factories\Factory;

class Puesto_DisponibleFactory extends Factory
{
    protected $model = Puesto_Disponible::class;

    public function definition()
    {
        return [
            "nombre" => $this->faker->jobTitle(),
            "area" => $this->faker->randomElement(['RRHH','TI','Ventas','Marketing','Finanzas']),
            "descripcion" => $this->faker->paragraph(),
            "requisitos" => $this->faker->paragraph(),
            "tipo_contrato" => $this->faker->randomElement(['Tiempo completo','Medio tiempo','Temporal']),
            "modalidad" => $this->faker->randomElement(['Presencial','Híbrido','Remoto']),
            "nivel" => $this->faker->randomElement(['Junior','Semi Senior','Senior']),
            "salario" => $this->faker->numberBetween(3000, 15000)." Bs",
            "ubicacion" => $this->faker->city(),
            "vacantes" => $this->faker->numberBetween(1, 10),
            "fecha_limite" => $this->faker->dateTimeBetween('+1 week', '+3 months'),
            "estado" => $this->faker->randomElement(['Activo','Inactivo']),
            "beneficios" => $this->faker->sentence(),
            "tenant_id" => "empresa1",
            "postulado" => false,
        ];
    }
}
