<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function updated(User $user)
    {
        cache()->forget('user_.'.$user->id);
    }

    public function deleted(User $user)
    {
        cache()->forget('user_.'.$user->id);
    }
}
