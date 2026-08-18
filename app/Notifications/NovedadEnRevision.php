<?php

namespace App\Notifications;

use App\EstacionNovedad;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NovedadEnRevision extends Notification implements ShouldQueue
{
    use Queueable;

    protected $novedad;
    protected $usuario;

    public function __construct(EstacionNovedad $novedad, $usuario)
    {
        $this->novedad = $novedad;
        $this->usuario = $usuario;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $url = url('/estacion-novedades/' . $this->novedad->id);
        $codigo = 'NOV-' . str_pad($this->novedad->id, 6, '0', STR_PAD_LEFT);
        
        return (new MailMessage)
            ->subject('🔔 Nueva Novedad en Revisión - ' . $codigo)
            ->greeting('Hola ' . $notifiable->name . '!')
            ->line('Se ha enviado una novedad a revisión.')
            ->line('**Código:** ' . $codigo)
            ->line('**Estación:** ' . ($this->novedad->estacion->nombre ?? 'N/A'))
            ->line('**Fecha:** ' . $this->novedad->fecha->format('d/m/Y'))
            ->line('**Elaborado por:** ' . ($this->novedad->usuarioElabora->name ?? 'N/A'))
            ->action('Ver Novedad', $url)
            ->line('Por favor, revise la novedad y tome las acciones correspondientes.')
            ->salutation('Saludos, ' . config('app.name'));
    }

    public function toDatabase($notifiable)
    {
        return [
            'novedad_id' => $this->novedad->id,
            'codigo' => 'NOV-' . str_pad($this->novedad->id, 6, '0', STR_PAD_LEFT),
            'mensaje' => 'La novedad ha sido enviada a revisión por ' . ($this->usuario->name ?? 'N/A'),
            'url' => '/estacion-novedades/' . $this->novedad->id,
        ];
    }
}