<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class HelloNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {

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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Domicilio !!',
            'body' => 'Su pedido esta en la recepcion.',
            'action_url' => '/admin/notificacion/0',
            'icono' => 'fas fa-bell mr-2',
            'created' => Carbon::now()->toIso8601String(),
        ];

        // return [
        //     'entregaid' => $this->entrega->id,
        //     'icono' => 'fas fa-concierge-bell',
        //     'title' => 'Domicilio',
        //     'body' => 'Su pedido esta en la recepcion.',
        //     'action_url' => '/admin/notificacion/0',
        //     'tipoentregaid' => $this->entrega->tipoentregaid,
        //     'entregareceptor' => $this->entrega->entregareceptor,
        //     'entregadestinatario' => $this->entrega->entregadestinatario,
        //     'fecharecibo' => $this->entrega->created_at,
        //     'descripcion' => $this->entrega->entregaobservacion,

        // ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Domicilio !!')
            ->icon('/notification-icon.png')
            ->body('Su pedido esta en la recepcion.')
            ->action('View app', 'view_app')
            ->data(['id' => $notification->id]);

        // return (new WebPushMessage)

        //     ->title('Domicilio !!')
        //     ->icon('/notification-icon.png')
        //     ->body('Su pedido esta en la recepcion.')
        //     ->action('View app', 'view_app')
        //     ->data(['id' => $this->entrega->id]);

    }
}
