<?php

namespace App\Notifications;

use App\Models\Permiso;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notificación general para avisar al empleado sobre el estado de su permiso (aprobado o rechazado).
 */
class PermisosNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $permiso;
    public $status; // 'solicitado', 'aprobado' o 'rechazado'

    /**
     * Create a new notification instance.
     *
     * @param Permiso $permiso El objeto Permiso afectado.
     * @param string $status El estado actual del permiso.
     * @return void
     */
    public function __construct(Permiso $permiso, string $status)
    {
        $this->permiso = $permiso;
        $this->status = $status;
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
        $subject = 'Actualización de Permiso';
        $greeting = 'Hola ' . $notifiable->name;
        $actionText = 'Ver Detalles';
        
        switch ($this->status) {
            case 'aprobado':
                $subject = '✅ Permiso Aprobado';
                $line = "Tu solicitud de permiso ({$this->permiso->motivo}) ha sido APROBADA. ¡Que disfrutes tu tiempo!";
                break;
            case 'rechazado':
                $subject = '❌ Permiso Rechazado';
                $line = "Tu solicitud de permiso ({$this->permiso->motivo}) ha sido RECHAZADA. Revisa el historial para ver la razón.";
                break;
            case 'solicitado':
                $subject = '✉️ Nueva Solicitud de Permiso';
                $line = "El empleado {$this->permiso->user->name} ha solicitado un nuevo permiso ({$this->permiso->motivo}). Requiere tu revisión.";
                break;
            default:
                $line = "El estado de tu permiso ha sido actualizado a '{$this->status}'.";
                break;
        }

        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line($line)
            ->line("Periodo solicitado: del {$this->permiso->fecha_inicio->format('d/m/Y')} al {$this->permiso->fecha_fin->format('d/m/Y')}")
            ->action($actionText, route('permisos.historial'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'permiso_id' => $this->permiso->id,
            'motivo' => $this->permiso->motivo,
            'status' => $this->status,
        ];
    }
}