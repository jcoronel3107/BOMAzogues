<?php

namespace App\Notifications;

use App\Movilizacion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MovilizacionCreada extends Notification implements ShouldQueue
{
    use Queueable;

    protected $movilizacion;
    protected $usuario;

    public function __construct(Movilizacion $movilizacion, $usuario)
    {
        $this->movilizacion = $movilizacion;
        $this->usuario = $usuario;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $url = url('/movilizaciones/' . $this->movilizacion->id);
        $codigo = 'MOV-' . str_pad($this->movilizacion->id, 6, '0', STR_PAD_LEFT);
        
        return (new MailMessage)
            ->subject('🚛 Nueva Movilización - ' . $codigo)
            ->greeting('Hola ' . $notifiable->name . '!')
            ->line('Se ha creado una nueva movilización de unidad.')
            ->line('**Código:** ' . $codigo)
            ->line('**Fecha Salida:** ' . \Carbon\Carbon::parse($this->movilizacion->fecha_salida)->format('d/m/Y'))
            ->line('**Hora Salida:** ' . $this->movilizacion->hora_salida)
            ->line('**Motivo:** ' . $this->movilizacion->motivo)
            ->line('**Destino:** ' . $this->movilizacion->destino)
            ->line('**Conductor:** ' . $this->movilizacion->conductor_nombres)
            ->line('**Vehículo:** ' . $this->movilizacion->vehiculo_placa . ' - ' . $this->movilizacion->vehiculo_marca)
            ->action('Ver Movilización', $url)
            ->line('Por favor, autorice o rechace la movilización.')
            ->salutation('Saludos, ' . config('app.name'));
    }

    public function toDatabase($notifiable)
    {
        return [
            'movilizacion_id' => $this->movilizacion->id,
            'codigo' => 'MOV-' . str_pad($this->movilizacion->id, 6, '0', STR_PAD_LEFT),
            'mensaje' => 'Nueva movilización creada por ' . ($this->usuario->name ?? 'N/A'),
            'url' => '/movilizaciones/' . $this->movilizacion->id,
        ];
    }
}