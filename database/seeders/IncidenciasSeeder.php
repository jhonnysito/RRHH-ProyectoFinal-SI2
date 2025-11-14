<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Incidencia;

class IncidenciasSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Vacaciones', 'descripcion' => 'Vacaciones anuales'],
            ['nombre' => 'Enfermedad', 'descripcion' => 'Baja médica'],
            ['nombre' => 'Cita médica', 'descripcion' => 'Cita con profesional de salud'],
            ['nombre' => 'Asuntos personales', 'descripcion' => 'Asuntos personales o trámites'],
            ['nombre' => 'Accidente', 'descripcion' => 'Accidente laboral o personal'],
        ];

        foreach ($tipos as $t) {
            Incidencia::updateOrCreate(['nombre' => $t['nombre']], $t);
        }
    }
}
