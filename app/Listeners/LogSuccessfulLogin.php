<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\Bitacora;
use App\Models\DetalleBitacora;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Log::info('=== LogSuccessfulLogin HANDLE METHOD CALLED ===');
        Log::info('Event class: ' . get_class($event));
        Log::info('Event user exists: ' . (isset($event->user) ? 'yes' : 'no'));
        Log::info('=== INICIANDO LogSuccessfulLogin ===');
        Log::info('Usuario ID: ' . $event->user->id);
        Log::info('Usuario name: ' . $event->user->name);

        try {
            $tipo = null;

            if (isset($event->user->postulante) && $event->user->postulante && !isset($event->user->empleado) || !$event->user->empleado) {
                $tipo = 'Postulante';
            } elseif ((!isset($event->user->postulante) || !$event->user->postulante) && isset($event->user->empleado) && $event->user->empleado) {
                $tipo = 'Empleado';
            }

            Log::info('Tipo determinado: ' . ($tipo ?? 'null'));

            // Datos de la bitácora
            $bitacoraData = [
                'ID_Usuario' => $event->user->id,
                'entrada' => Crypt::encrypt(now()),
                'salida' => null,
                'usuario' => Crypt::encrypt($event->user->name),
                'tipo' => Crypt::encrypt($tipo),
                'direccionIp' => Crypt::encrypt(request()->ip()),
                'navegador' => Crypt::encrypt(request()->header('user-agent')),
            ];

            Log::info('Creando bitácora con datos: ' . json_encode($bitacoraData));

            $bitacora = $event->user->bitacoras()->create($bitacoraData);

            Log::info('Bitácora creada con ID: ' . $bitacora->id);

            // Detalle de la bitácora
            $detalleBitacoraData = [
                'ID_Bitacora' => $bitacora->id,
                'accion' => Crypt::encrypt('Iniciar Sesión'),
                'metodo' => Crypt::encrypt(request()->method()),
                'hora' => Crypt::encrypt(Carbon::now()->format('H:i:s')),
                'tabla' => Crypt::encrypt('usuarios'),
                'registroId' => null,
                'ruta' => Crypt::encrypt(request()->fullurl()),
            ];

            Log::info('Creando detalle bitácora con datos: ' . json_encode($detalleBitacoraData));

            $bitacora->detalleBitacoras()->create($detalleBitacoraData);

            session(['bitacora_id' => $bitacora->id]);

            Log::info('Bitácora y detalle creados exitosamente para usuario: ' . $event->user->id);
            Log::info('=== FINALIZANDO LogSuccessfulLogin ===');
        } catch (\Exception $e) {
            Log::error('=== ERROR en LogSuccessfulLogin ===');
            Log::error('Mensaje: ' . $e->getMessage());
            Log::error('Archivo: ' . $e->getFile());
            Log::error('Línea: ' . $e->getLine());
            Log::error('Trace: ' . $e->getTraceAsString());
        }
    }
}
