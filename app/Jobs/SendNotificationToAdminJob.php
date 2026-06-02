<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationToAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public array $title, public array $body, public ?string $url = null, public $permission = null) {}

    public function handle(): void
    {
        User::role('admin')->when($this->permission, function ($query) {
            $query->whereHas('permissions', function ($q) {
                $q->where('name', $this->permission);
            });
        })->cursor()->each(function ($admin) {
            $admin->notify(new AdminNotification($this->title, $this->body, $this->url));
        });
    }
}
