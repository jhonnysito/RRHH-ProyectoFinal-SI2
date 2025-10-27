<?php

namespace App\Mail;

use App\Models\Empleado;
use App\Models\Contrato;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContratoCreadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $empleado;
    public $contrato;

    /**
     * Create a new message instance.
     */
    public function __construct($empleado, $contrato)
    {
        $this->empleado = $empleado;
        $this->contrato = $contrato;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Nuevo Contrato de Trabajo')
                    ->markdown('emails.contratos.creado', [
                        'empleado' => $this->empleado,
                        'contrato' => $this->contrato,
                    ]);
    }
}
