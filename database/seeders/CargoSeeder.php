<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departamento;
use App\Models\Cargo;

class CargoSeeder extends Seeder
{
    public function run()
    {
        $departamentos = [
            'Marketing' => ['Gerente de Marketing', 'Asistente de Marketing', 'Analista de Marketing'],
            'Contabilidad' => ['Contador', 'Auxiliar Contable', 'Jefe de Contabilidad'],
            'Ventas' => ['Jefe de Ventas', 'Ejecutivo de Ventas', 'Vendedor'],
            'Tecnología' => ['Jefe de TI', 'Desarrollador', 'Analista de Sistemas'],
            'Finanzas' => ['Analista Financiero', 'Tesorería', 'Gerente Financiero'],
            'Operaciones' => ['Jefe de Operaciones', 'Supervisor de Producción', 'Operario']
        ];

        foreach ($departamentos as $nombreDepartamento => $cargos) {
            // Obtener el departamento existente
            $departamento = Departamento::where('nombre', $nombreDepartamento)->first();

            if (!$departamento) {
                continue; // si no existe, saltar
            }

            foreach ($cargos as $cargoNombre) {
                Cargo::create([
                    'departamento_id' => $departamento->id,
                    'nombre'          => $cargoNombre,
                    'descripcion'     => 'Cargo de ' . $cargoNombre,
                    'tenant_id'       => 'empresa1',
                ]);
            }
        }
    }
}
