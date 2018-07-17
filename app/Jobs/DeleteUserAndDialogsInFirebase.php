<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 7/17/18
 * Time: 11:36
 */

namespace App\Jobs;


use App\Firebase\Firebase;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class DeleteUserAndDialogsInFirebase extends Job
{
    protected $to_delete;

    public function __construct(User $to_delete)
    {
        $this->to_delete = $to_delete;
    }

    public function fire()
    {
        $user = $this->to_delete;
        if (!$user->uid) {
            Log::debug("User #{$user->id} is not registered in firebase yet, waiting...");
            $this->release(self::DELAY);
            return;
        }

        Log::debug("Trying to delete user #{$user->id} in firebase");

        $firebase = new Firebase();
        $firebase->deleteUserAndDialogs($user);

        Log::debug("User #{$user->id} successfully deleted in firebase");
    }
}