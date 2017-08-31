<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-31
 * Time: 14:09
 */

namespace App\Models\Contracts;


class EmailLinkContract
{
    const _TABLE = 'email_links';
    const ID = 'id';
    const HASH = 'hash';
    const ACTION = 'action';
    const USER_ID = 'user_id';
    const METADATA = 'metadata';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}