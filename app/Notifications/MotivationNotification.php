<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class MotivationNotification extends Notification
{
    use Queueable;

    public function __construct(public \App\Models\Motivation $motivation) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'   => 'daily',
            'body'   => $this->motivation->body,
            'topic'     => $this->motivation->topic?->name ?? 'General',
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
