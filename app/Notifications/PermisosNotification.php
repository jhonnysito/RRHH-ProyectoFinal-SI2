<?php

namespace App\Notifications;

use App\Models\PermisoEmpleado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

/**
 * Notificación general para avisar al empleado sobre el estado de su permiso (aprobado o rechazado).
 */
class PermisosNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $permiso;
    public $status;
    public $sender; 

    /**
     * Create a new notification instance.
     *
     * @param Permiso $permiso El objeto Permiso afectado.
     * @param string $status El estado actual del permiso.
     * @param User $sender El usuario que origina la acción
     */
    public function __construct(PermisoEmpleado $permiso, string $status,User $sender)
    {
        $this->permiso = $permiso;
        $this->status = $status;
        $this->sender = $sender;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Enviamos por email y lo guardamos en BD
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $actionUrl = route('permisos.show', $this->permiso);
        $line = "";
        $subject = "";

        if ($this->status == 'solicitado') {
            $subject = "Nueva Solicitud de Permiso: " . $this->sender->name;
            $line = "El empleado **{$this->sender->name}** ha solicitado un permiso por: **{$this->permiso->incidencia->nombre}**.";
        } elseif ($this->status == 'aprobado') {
            $subject = "✅ Solicitud Aprobada";
            $line = "Tu solicitud de permiso por **{$this->permiso->incidencia->nombre}** ha sido **APROBADA**.";
        } elseif ($this->status == 'rechazado') {
            $subject = "❌ Solicitud Rechazada";
            $line = "Tu solicitud de permiso por **{$this->permiso->incidencia->nombre}** ha sido **RECHAZADA**.";
        }

        return (new MailMessage)
                    ->subject($subject)
                    ->line($line)
                    ->line("Motivo: " . $this->permiso->motivo)
                    ->action('Ver Detalle de la Solicitud', $actionUrl)
                    ->line('Gracias por usar el sistema.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

        $line = "";
        if ($this->status == 'solicitado') {
            $line = "{$this->sender->name} ha solicitado un permiso.";
        } elseif ($this->status == 'aprobado') {
            $line = "Tu permiso de {$this->permiso->incidencia->nombre} fue APROBADO.";
        } elseif ($this->status == 'rechazado') {
            $line = "Tu permiso de {$this->permiso->incidencia->nombre} fue RECHAZADO.";
        }
        return [
            'permiso_id' => $this->permiso->id,
            'mensaje' => $line,
            'remitente_id' => $this->sender->id,
            'remitente_nombre' => $this->sender->name,
            'url' => route('permisos.show', $this->permiso),
        ];
    }
}