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

            // Traemos los pagos del empleado (6 meses, según PagosSeeder)
            $pagos = $empleado->pagosEmpleado()->get();

            foreach ($pagos as $pago) {

                $currentDate = Carbon::parse($pago->periodo_inicio);
                $endDate = Carbon::parse($pago->periodo_fin);

                while ($currentDate <= $endDate) {

                    // ---- Escenarios posibles ----
                    // 0 = NO MARCÓ NADA
                    // 1 = Solo entrada
                    // 2 = Solo salida
                    // 3 = Marcó ambas (normal o con retraso)
                    $escenario = rand(0, 3);

                    // Retraso en minutos (máx 90 min)
                    $retrasoEntrada = rand(0, 100) < 20 ? rand(10, 90) : 0; // 20% chance
                    $retrasoSalida  = rand(0, 100) < 20 ? rand(10, 90) : 0; // 20% chance

                    // Entrada → 08:00
                    $entrada = $currentDate->copy()->setTime(8, 0)->addMinutes($retrasoEntrada);

                    // Salida → 17:00
                    $salida  = $currentDate->copy()->setTime(17, 0)->addMinutes($retrasoSalida);

                    // ----------- MARCAR SEGÚN ESCENARIO ----------
                    switch ($escenario) {

                        case 1: // SOLO ENTRADA
                            LocationRecord::create([
                                'name'        => $empleado->nombre_completo,
                                'latitude'    => rand(-1000000, 1000000) / 1000000,
                                'longitude'   => rand(-1000000, 1000000) / 1000000,
                                'recorded_at' => $entrada,
                            ]);
                            break;

                        case 2: // SOLO SALIDA
                            LocationRecord::create([
                                'name'        => $empleado->nombre_completo,
                                'latitude'    => rand(-1000000, 1000000) / 1000000,
                                'longitude'   => rand(-1000000, 1000000) / 1000000,
                                'recorded_at' => $salida,
                            ]);
                            break;

                        case 3: // ENTRADA Y SALIDA (normal o con retraso)
                            LocationRecord::create([
                                'name'        => $empleado->nombre_completo,
                                'latitude'    => rand(-1000000, 1000000) / 1000000,
                                'longitude'   => rand(-1000000, 1000000) / 1000000,
                                'recorded_at' => $entrada,
                            ]);

                            LocationRecord::create([
                                'name'        => $empleado->nombre_completo,
                                'latitude'    => rand(-1000000, 1000000) / 1000000,
                                'longitude'   => rand(-1000000, 1000000) / 1000000,
                                'recorded_at' => $salida,
                            ]);
                            break;

                        case 0:
                        default:
                            // NO MARCA NADA ESTE DÍA
                            break;
                    }

                    $currentDate->addDay();
                }
            }
        }
    }
}
