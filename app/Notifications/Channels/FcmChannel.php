<?php

namespace App\Notifications\Channels;

use App\Services\NotificationFirebaseService;
use Illuminate\Support\Facades\Log;
use Throwable;

class FcmChannel
{
    public function send(object $notifiable, object $notification): void
    {
        if (! method_exists($notification, 'toFcm')) {
            return;
        }

        try {
            /** @var array{title?: string, body?: string, type?: array{id?: string|int, name?: string, procedure?: string}} $payload */
            $payload = $notification->toFcm($notifiable);

            NotificationFirebaseService::send($notifiable, $payload);
        } catch (Throwable $throwable) {
            Log::error('Unable to send FCM notification.', [
                'notification' => $notification::class,
                'notifiable' => $notifiable::class,
                'message' => $throwable->getMessage(),
            ]);
        }
    }
}
