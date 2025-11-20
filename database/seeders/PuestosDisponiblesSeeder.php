<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Puesto_Disponible;
use App\Models\Departamento;
use Illuminate\Support\Str;

class PuestosDisponiblesSeeder extends Seeder
{
    public function run()
    {
        // Departamentos que existen
        $departamentos = Departamento::all();

        // Tipos de contrato y modalidades
        $tiposContrato = ['Indefinido', 'Plazo fijo', 'Prácticas'];
        $modalidades = ['Presencial', 'Remoto', 'Híbrido'];
        $niveles = ['Junior', 'Semi-Senior', 'Senior'];
        $beneficios = ['Seguro médico', 'Bonos', 'Vacaciones pagadas', 'Capacitación'];
        $ubicaciones = ['La Paz', 'Santa Cruz', 'Cochabamba', 'Sucre'];

        // Creamos 10 puestos disponibles
        for ($i = 1; $i <= 10; $i++) {
            $departamento = $departamentos->random(); // Elegir departamento aleatorio

            Puesto_Disponible::create([
                'nombre'        => 'Puesto ' . $i . ' - ' . $departamento->nombre,
                'area'          => $departamento->nombre,
                'descripcion'   => 'Descripción del puesto ' . $i,
                'requisitos'    => 'Requisitos para el puesto ' . $i,
                'tipo_contrato' => $tiposContrato[array_rand($tiposContrato)],
                'modalidad'     => $modalidades[array_rand($modalidades)],
                'nivel'         => $niveles[array_rand($niveles)],
                'salario'       => rand(3000, 10000),
                'ubicacion'     => $ubicaciones[array_rand($ubicaciones)],
                'vacantes'      => rand(1, 5),
                'fecha_limite'  => now()->addWeeks(rand(2, 8)),
                'estado'        => 'Activo',
                'beneficios'    => implode(', ', $beneficios),
                'tenant_id'     => 'empresa1',
                'postulado'     => 0,
            ]);
        }
    }
}
