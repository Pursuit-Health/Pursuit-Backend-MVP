<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 12/16/17
 * Time: 18:24
 */

namespace App\Jobs;


use App\Models\User;
use Illuminate\Support\Facades\Log;

class CreateUserAndDialogInFirebase extends Job
{
    protected $to_create;
    protected $existing;

    public function __construct(User $to_create, User $existing)
    {
        $this->to_create = $to_create;
        $this->existing = $existing;
    }

    public function fire()
    {
        $user1 = $this->to_create;
        $user2 = $this->existing;
        if (!$user2->uid) {
            Log::debug("User #{$user2->id} is not registered in firebase yet, waiting...");
            $this->release(self::DELAY);
            return;
        }

        dispatch((new CreateUserInFirebase($user1))->onConnection('sync'));
        dispatch((new CreateDialogInFirebase($user1, $user2))->onConnection('sync'));
    }
}