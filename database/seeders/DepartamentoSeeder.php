<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departamento;

class DepartamentoSeeder extends Seeder
{
    public function run()
    {
        $departamentos = [
            'Marketing',
            'Contabilidad',
            'Ventas',
            'Tecnología',
            'Finanzas',
            'Operaciones',
        ];

        foreach ($departamentos as $dpto) {
            Departamento::create([
                'tenant_id'   => 'empresa1',
                'nombre'      => $dpto,
                'descripcion' => 'Departamento de ' . $dpto,
            ]);
        }
    }
}
