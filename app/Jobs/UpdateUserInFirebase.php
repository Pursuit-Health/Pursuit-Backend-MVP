<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 12/16/17
 * Time: 15:19
 */

namespace App\Jobs;


use App\Firebase\Firebase;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UpdateUserInFirebase extends Job
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function fire()
    {
        $user = $this->user;

        if (!$user->uid) {
            Log::debug("User #{$user->id} is not registered in firebase yet, waiting...");
            $this->release(self::DELAY);
            return;
        }

        Log::debug("Trying to update user #{$user->id} in firebase");

        $firebase = new Firebase();
        $firebase->updateUser($user);

        Log::debug("User #{$user->id} successfully updated in firebase");
    }
}