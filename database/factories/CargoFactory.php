<?php

namespace Database\Factories;

use App\Models\Cargo;
use App\Models\Departamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class CargoFactory extends Factory
{
    protected $model = Cargo::class;

    public function definition()
    {
        // Lista de cargos típicos de una empresa
        $cargos = [
            'Gerente General',
            'Gerente de Recursos Humanos',
            'Supervisor de Ventas',
            'Analista Contable',
            'Jefe de Almacén',
            'Auxiliar de Oficina',
            'Auxiliar Administrativo',
            'Secretaria',
            'Asistente de RRHH',
            'Coordinador de Producción',
            'Operario',
            'Recepcionista',
            'Vendedor',
            'Cajero',
        ];

        return [
            'tenant_id'       => 'empresa1',
            'nombre'          => $this->faker->unique()->randomElement($cargos),
            'descripcion'     => $this->faker->sentence(12),
            'departamento_id' => Departamento::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
