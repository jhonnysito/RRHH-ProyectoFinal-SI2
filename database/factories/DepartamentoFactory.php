<?php

namespace Database\Factories;

use App\Models\Departamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartamentoFactory extends Factory
{
    protected $model = Departamento::class;

    public function definition()
    {
        // Lista de departamentos posibles en la empresa
        $departamentos = [
            'Marketing',
            'Contabilidad',
            'Recursos Humanos',
            'Ventas',
            'Tecnología',
            'Finanzas',
            'Operaciones',
        ];

        return [
            'tenant_id'   => 'empresa1',
            // Quitamos unique() para evitar OverflowException
            // Asegúrate de no crear más registros de los elementos de la lista
            'nombre'      => $this->faker->randomElement($departamentos),
            'descripcion' => $this->faker->sentence(10),
        ];
    }
}
