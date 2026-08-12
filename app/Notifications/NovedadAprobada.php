<?php

namespace App\Notifications;

use App\EstacionNovedad;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NovedadAprobada extends Notification implements ShouldQueue
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
        return ['database']; // Solo guardar en base de datos
    }

    public function toMail($notifiable)
    {
        $url = url('/estacion-novedades/' . $this->novedad->id);
        
        return (new MailMessage)
            ->subject('Novedad Aprobada - NOV-' . str_pad($this->novedad->id, 6, '0', STR_PAD_LEFT))
            ->greeting('Hola ' . $notifiable->name . '!')
            ->line('La novedad ha sido aprobada.')
            ->line('**Código:** NOV-' . str_pad($this->novedad->id, 6, '0', STR_PAD_LEFT))
            ->line('**Estación:** ' . ($this->novedad->estacion->nombre ?? 'N/A'))
            ->line('**Fecha:** ' . $this->novedad->fecha->format('d/m/Y'))
            ->line('**Aprobado por:** ' . ($this->novedad->usuarioAprueba->name ?? 'N/A'))
            ->action('Ver Novedad', $url)
            ->line('La novedad ha sido aprobada y queda bloqueada para edición.')
            ->salutation('Saludos, ' . config('app.name'));
    }

    public function toDatabase($notifiable)
    {
        return [
            'novedad_id' => $this->novedad->id,
            'codigo' => 'NOV-' . str_pad($this->novedad->id, 6, '0', STR_PAD_LEFT),
            'estacion' => $this->novedad->estacion->nombre ?? 'N/A',
            'fecha' => $this->novedad->fecha->format('d/m/Y'),
            'aprobado_por' => $this->novedad->usuarioAprueba->name ?? 'N/A',
            'mensaje' => 'La novedad NOV-' . str_pad($this->novedad->id, 6, '0', STR_PAD_LEFT) . ' ha sido aprobada por ' . ($this->novedad->usuarioAprueba->name ?? 'N/A'),
            'url' => '/estacion-novedades/' . $this->novedad->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'novedad_id' => $this->novedad->id,
            'codigo' => 'NOV-' . str_pad($this->novedad->id, 6, '0', STR_PAD_LEFT),
            'mensaje' => 'Novedad NOV-' . str_pad($this->novedad->id, 6, '0', STR_PAD_LEFT) . ' ha sido aprobada',
            'url' => '/estacion-novedades/' . $this->novedad->id,
        ];
    }
}