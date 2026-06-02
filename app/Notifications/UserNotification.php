<?php

namespace App\Notifications;

use App\Notifications\Channels\FcmChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
    use Queueable;

    public function __construct(public array $title, public array $body, public array $data = [])
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    public function toFcm(object $notifiable): array
    {
        $locale = $notifiable->language ?? app()->getLocale();
        $locale = $locale === 'ar' ? 'ar' : 'en';

        return [
            'title' => $this->title[$locale] ?? $this->title['en'] ?? $this->title['ar'] ?? '',
            'body' => $this->body[$locale] ?? $this->body['en'] ?? $this->body['ar'] ?? '',
            'data' => $this->data,
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'data' => $this->data,
        ];
    }
}
