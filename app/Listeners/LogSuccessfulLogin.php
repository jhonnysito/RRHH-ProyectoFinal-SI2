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


        Log::info('Bitácora registrada para usuario: ' . $event->user->id);
        Log::info('Ejecutando LogSuccessfulLogin para usuario: ' . $event->user->id);

        $tipo = null;

        if ($event->user->postulante && !$event->user->empleado) {
            $tipo = 'Postulante';
        } elseif (!$event->user->postulante && $event->user->empleado) {
            $tipo = 'Empleado';
        }


        // Datos de la bitácora
        $bitacoraData = [
            'entrada' => Crypt::encrypt(now()),
            'salida' => null,
            'usuario' => Crypt::encrypt($event->user->name),
            'tipo' => Crypt::encrypt($tipo),
            'direccionIp' => Crypt::encrypt(request()->ip()),
            'navegador' => Crypt::encrypt(request()->header('user-agent')),
        ];

        $bitacora = $event->user->bitacoras()->create($bitacoraData);

        // Detalle de la bitácora
        $detalleBitacoraData = [
            'accion' => Crypt::encrypt('Iniciar Sesión'),
            'metodo' => Crypt::encrypt(request()->method()),
            'hora' => Crypt::encrypt(Carbon::now()->format('H:i:s')),
            'tabla' => Crypt::encrypt('usuarios'),
            'registroId' => null,
            'ruta' => Crypt::encrypt(request()->fullurl()),
        ];

        $bitacora->detalleBitacoras()->create($detalleBitacoraData);

        session(['bitacora_id' => $bitacora->id]);
    }
}
