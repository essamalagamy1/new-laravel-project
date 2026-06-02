<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

class UpdateUserTimezone
{
    /**
     * Create the event listener.
     */
    public function __construct(protected Request $request)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;

        $timezone = getTimezoneByIP($this->request->ip());

        if ($timezone && $user->timezone !== $timezone) {
            $user->updateQuietly(['timezone' => $timezone]);
        }
    }
}
