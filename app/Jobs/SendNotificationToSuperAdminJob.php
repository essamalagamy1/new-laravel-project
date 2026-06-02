<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationToSuperAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public array $title, public array $body, public ?string $url = null) {}

    public function handle(): void
    {
        User::role('superadmin')->cursor()->each(function ($superadmin) {
            $superadmin->notify(new AdminNotification($this->title, $this->body, $this->url));
        });
    }
}
