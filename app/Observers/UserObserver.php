<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 12/16/17
 * Time: 17:55
 */

namespace App\Observers;


use App\Jobs\CreateUserInFirebase;
use App\Jobs\UpdateUserInFirebase;
use App\Models\Trainer;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        if ($user->userable_type === Trainer::class) {
            dispatch(new CreateUserInFirebase($user));
        }
    }

    public function updated(User $user): void
    {
        if ($user->isDirty(['name', 'avatar_url'])) {
            dispatch(new UpdateUserInFirebase($user));
        }
    }
}