<?php

namespace App\Listeners;

use App\Models\Bitacora;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Crypt;

class LogSuccessfulLogout
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
        $bitacora = Bitacora::where('ID_Usuario', $event->user->id)
            ->latest()
            ->first();

        if ($bitacora) {
            $bitacora->update([
                'salida' => Crypt::encrypt(now()),
            ]);
        }

        $horaActual = Crypt::encrypt(Carbon::now()->format('H:i:s'));

        // Detalle de la bitácora
        $detalleBitacoraData = [
            'accion' => Crypt::encrypt('Cerrar Sesión'),
            'metodo' => Crypt::encrypt(request()->method()),
            'hora' => $horaActual,
            'tabla' => Crypt::encrypt('usuarios'),
            'registroId' => null,
            'ruta' => Crypt::encrypt(request()->fullurl()),
        ];

        $bitacora->detalleBitacoras()->create($detalleBitacoraData);
    }
}
