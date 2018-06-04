<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 12/16/17
 * Time: 18:08
 */

namespace App\Models\Contracts;


class DialogContract
{
    public const _TABLE = 'dialogs';
    public const ID = 'id';
    public const USER_ID1 = 'user_id1';
    public const USER_ID2 = 'user_id2';
    public const DIALOG_UID = 'dialog_uid';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
}