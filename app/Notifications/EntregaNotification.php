<?php

namespace App\Notifications;

use App\Models\Entrega;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class EntregaNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Entrega $entrega)
    {
        $this->entrega = $entrega;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast', WebPushChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'entregaid' => $this->entrega->id,
            'icono' => $this->entrega->tipoentregaicono,
            'title' => 'Portero',
            'empresa' => 'De: '.ucfirst($this->entrega->empresa),
            'body' => 'Tiene un '. strtolower($this->entrega->title) .' en recepción.',
            'action_url' => '/admin/notificacion/0',
            'tipoentregaid' => $this->entrega->tipoentregaid,
            'entregareceptor' => $this->entrega->entregareceptor,
            'entregadestinatario' => $this->entrega->entregadestinatario,
            'fecharecibo' => $this->entrega->created_at,
            'descripcion' => $this->entrega->entregaobservacion,

        ];
    }

    public function toWebPush($notifiable, $entrega)
    {
        return (new WebPushMessage)
            ->title('Portero')
            ->icon('/notification-icon.png')
            ->body('Tiene un '. strtolower($this->entrega->title) .' en recepción.')
            ->action('Ver app', url('/admin/notificacion/0'))
            ->data(['id' => $this->entrega->id]);

        // return (new WebPushMessage)

        //     ->title('Domicilio !!')
        //     ->icon('/notification-icon.png')
        //     ->body('Su pedido esta en la recepcion.')
        //     ->action('View app', 'view_app')
        //     ->data(['id' => $this->entrega->id]);

    }
}
