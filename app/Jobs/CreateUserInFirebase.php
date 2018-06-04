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

class CreateUserInFirebase extends Job
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function fire()
    {
        $user = $this->user;
        Log::debug("Trying to create user #{$user->id} in firebase");

        $firebase = new Firebase();
        $uid = $firebase->createUser($user);
        $user->uid = $uid;
        $user->save();

        Log::debug("User #{$user->id} successfully created in firebase with UID: {$uid}");
    }
}