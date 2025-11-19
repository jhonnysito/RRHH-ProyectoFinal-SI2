<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empleado;
use App\Models\LocationRecord;
use Carbon\Carbon;

class LocationRecordSeeder extends Seeder
{
    public function run(): void
    {
        $empleados = Empleado::all();

        foreach ($empleados as $empleado) {

            // Traemos los pagos del empleado (6 meses, según el PagosSeeder)
            $pagos = $empleado->pagosEmpleado()->get(); // O PagoEmpleado::where('empleado_id', $empleado->user_id)->get();

            foreach ($pagos as $pago) {

                // Generamos registros para cada día del periodo
                $currentDate = Carbon::parse($pago->periodo_inicio);
                $endDate = Carbon::parse($pago->periodo_fin);

                while ($currentDate <= $endDate) {

                    // Simulamos que en algunos días el empleado se olvidó de marcar entrada o salida
                    $entradaOlvidada = rand(0, 20) === 0; // 1 de cada 20 días
                    $salidaOlvidada = rand(0, 20) === 0;

                    // Registro de entrada
                    if (!$entradaOlvidada) {
                        LocationRecord::create([
                            'name' => $empleado->nombre_completo,
                            'latitude' => rand(-1000000, 1000000) / 1000000,
                            'longitude' => rand(-1000000, 1000000) / 1000000,
                            'recorded_at' => $currentDate->copy()->setTime(8, rand(0, 30)), // 08:00 ±30min
                        ]);
                    }

                    // Registro de salida
                    if (!$salidaOlvidada) {
                        LocationRecord::create([
                            'name' => $empleado->nombre_completo,
                            'latitude' => rand(-1000000, 1000000) / 1000000,
                            'longitude' => rand(-1000000, 1000000) / 1000000,
                            'recorded_at' => $currentDate->copy()->setTime(17, rand(0, 30)), // 17:00 ±30min
                        ]);
                    }

                    $currentDate->addDay();
                }
            }
        }
    }
}
