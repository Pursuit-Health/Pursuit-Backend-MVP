<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 12/16/17
 * Time: 18:04
 */

namespace App\Jobs;


use App\Firebase\Firebase;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CreateDialogInFirebase extends FirebaseJob
{

    protected $user1;
    protected $user2;

    public function __construct(User $user1, User $user2)
    {
        $this->user1 = $user1;
        $this->user2 = $user2;
    }

    public function fire()
    {
        $user1 = $this->user1;
        $user2 = $this->user2;

        if (!$user1->uid) {
            Log::debug("User #{$user1->id} is not registered in firebase yet, waiting...");
            $this->release(self::DELAY);
            return;
        }

        if (!$user2->uid) {
            Log::debug("User #{$user2->id} is not registered in firebase yet, waiting...");
            $this->release(self::DELAY);
            return;
        }

        Log::debug("Trying to create dialog between users #{$user1->id} and #{$user2->id}");

        $firebase = new Firebase();
        $dialog = $firebase->createDialog($user1, $user2);

        Log::debug("Dialog between users #{$user1->id} and #{$user2->id} successfully created UID: {$dialog->dialog_uid}");
    }
}