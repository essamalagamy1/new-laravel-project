<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AdminNotification extends Notification
{
    public function __construct(public array $title, public array $body, public ?string $url = null, public $permission = null) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'url' => $this->url,
        ];
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
