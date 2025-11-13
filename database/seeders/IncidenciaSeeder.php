<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class IncidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('incidencias')->insert([
            ['nombre' => 'Vacaciones Anuales', 'descripcion' => 'Permiso por días libres anuales reglamentarios.'],
            ['nombre' => 'Cita Médica', 'descripcion' => 'Permiso por citas médicas personales o familiares urgentes.'],
            ['nombre' => 'Asuntos Personales', 'descripcion' => 'Permiso para atender gestiones o asuntos personales.'],
        ]);
    }

    
}
    