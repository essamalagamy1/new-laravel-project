<?php

namespace App\Observers;

use App\Actions\Media\GenerateRandomImageAction;
use App\Models\User;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class UserObserver implements ShouldHandleEventsAfterCommit
{
    public function created(User $user): void
    {
        if (! $user->getFirstMediaUrl('image')) {
            $action = app(GenerateRandomImageAction::class);
            $action->execute($user);
        }

        $user->username = $user->id.rand(100000, 999999);
        $user->save();
    }
}
