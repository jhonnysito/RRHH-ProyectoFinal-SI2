<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Empleado;
use App\Models\PagoEmpleado;
use App\Models\FaltaEmpleado;
use App\Models\AtrasoEmpleado;
use App\Models\DescuentoEmpleado;
use App\Models\VacacionEmpleado;
use Carbon\Carbon;

class PagosSeeder extends Seeder
{
    public function run(): void
    {
        // Traemos todos los empleados
        $empleados = Empleado::all();

        foreach ($empleados as $empleado) {
            $tenant = $empleado->tenant_id;

            // --- Crear pagos de ejemplo (6 meses)
            for ($i = 0; $i < 6; $i++) {
                $periodo_inicio = Carbon::now()->subMonths($i)->startOfMonth();
                $periodo_fin = Carbon::now()->subMonths($i)->endOfMonth();

                $salario_base = rand(1000, 3000);
                $total_bonos = rand(0, 0);
                $total_descuentos = rand(0, 0);
                $total_neto = $salario_base + $total_bonos - $total_descuentos;

                $pago = PagoEmpleado::create([
                    'tenant_id' => $tenant,
                    'empleado_id' => $empleado->user_id,
                    'salario_base' => $salario_base,
                    'total_bonos' => $total_bonos,
                    'total_descuentos' => $total_descuentos,
                    'total_neto' => $total_neto,
                    'periodo_inicio' => $periodo_inicio->format('Y-m-d'),
                    'periodo_fin' => $periodo_fin->format('Y-m-d'),
                    'fecha_pago' => $periodo_fin->format('Y-m-d'),
                    'estado' => 'pagado',
                ]);

                // --- Crear faltas de ejemplo (1-3 por mes)
                $faltas_count = rand(1, 3);
                for ($f = 0; $f < $faltas_count; $f++) {
                    FaltaEmpleado::create([
                        'tenant_id' => $tenant,
                        'empleado_id' => $empleado->user_id,
                        'pago_id' => $pago->id,
                        'fecha' => $periodo_inicio->copy()->addDays(rand(0, $periodo_inicio->daysInMonth - 1)),
                        'horas_afectadas' => rand(1, 8),
                        'motivo' => 'Falta de ejemplo',
                        'tipo' => 'justificada',
                        'descuento_generado' => rand(50, 200),
                    ]);
                }

                // --- Crear atrasos de ejemplo (1-3 por mes)
                $atrasos_count = rand(1, 3);
                for ($a = 0; $a < $atrasos_count; $a++) {
                    AtrasoEmpleado::create([
                        'tenant_id' => $tenant,
                        'empleado_id' => $empleado->user_id,
                        'pago_id' => $pago->id,
                        'fecha' => $periodo_inicio->copy()->addDays(rand(0, $periodo_inicio->daysInMonth - 1)),
                        'minutos_tarde' => rand(5, 60),
                        'descuento_generado' => rand(10, 50),
                    ]);
                }

                

                // --- Crear vacaciones de ejemplo (0-1 por mes)
                if (rand(0,1)) {
                    $vac_inicio = $periodo_inicio->copy()->addDays(rand(0, $periodo_inicio->daysInMonth - 5));
                    $vac_fin = $vac_inicio->copy()->addDays(rand(1,5));
                    $dias = $vac_inicio->diffInDays($vac_fin) + 1;

                    VacacionEmpleado::create([
                        'tenant_id' => $tenant,
                        'empleado_id' => $empleado->user_id,
                        'fecha_inicio' => $vac_inicio->format('Y-m-d'),
                        'fecha_fin' => $vac_fin->format('Y-m-d'),
                        'dias' => $dias,
                        'tipo' => 'pagadas',
                    ]);
                }
            }
        }
    }
}
