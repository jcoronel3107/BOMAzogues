<?php

namespace App\Notifications;

use App\Inspeccion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InspeccionCreada extends Notification implements ShouldQueue
{
    use Queueable;

    protected $inspeccion;
    protected $usuario;

    public function __construct(Inspeccion $inspeccion, $usuario)
    {
        $this->inspeccion = $inspeccion;
        $this->usuario = $usuario;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $url = url('/inspeccion/' . $this->inspeccion->id);
        
        return (new MailMessage)
            ->subject('🔍 Nueva Inspección - ' . $this->inspeccion->codigo_inspeccion)
            ->greeting('Hola ' . $notifiable->name . '!')
            ->line('Se ha creado una nueva inspección.')
            ->line('**Código:** ' . $this->inspeccion->codigo_inspeccion)
            ->line('**Fecha:** ' . $this->inspeccion->fecha_inspeccion->format('d/m/Y'))
            ->line('**Lugar:** ' . $this->inspeccion->lugar)
            ->line('**Tipo:** ' . ucfirst($this->inspeccion->tipo_inspeccion))
            ->line('**Inspector:** ' . ($this->inspeccion->inspector->name ?? 'N/A'))
            ->action('Ver Inspección', $url)
            ->line('Por favor, revise la inspección y tome las acciones correspondientes.')
            ->salutation('Saludos, ' . config('app.name'));
    }

    public function toDatabase($notifiable)
    {
        return [
            'inspeccion_id' => $this->inspeccion->id,
            'codigo' => $this->inspeccion->codigo_inspeccion,
            'mensaje' => 'Nueva inspección creada por ' . ($this->usuario->name ?? 'N/A'),
            'url' => '/inspeccion/' . $this->inspeccion->id,
        ];
    }
}