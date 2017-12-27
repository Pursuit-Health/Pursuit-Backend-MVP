<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 12/16/17
 * Time: 17:27
 */

namespace App\Firebase;


use App\Models\Dialog;
use App\Models\User;

trait FirebaseFunctions
{
    public function createUser(User $user)
    {
        $r = $this->request('createUser', [
            'id' => $user->id,
            'name' => $user->name,
            'photo' => 'https://' . env('APP_HOST') . $user->avatar_url,
        ], true);

        return $r['uid'];
    }

    public function updateUser(User $user)
    {
        $this->request('updateUser', [
            'uid' => $user->uid,
            'name' => $user->name,
            'photo' => 'https://' . env('APP_HOST') . $user->avatar_url,
        ]);
    }

    public function createDialog(User $user1, User $user2): Dialog
    {
        $r = $this->request('createDialog', [
            'uids' => [
                $user1->uid,
                $user2->uid,
            ]
        ], true);

        /**@var Dialog $dialog */
        $dialog = new Dialog();
        $dialog->dialog_uid = $r['dialog_uid'];
        $dialog->user_id1 = $user1->id;
        $dialog->user_id2 = $user2->id;
        $dialog->save();

        return $dialog;
    }
}