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
    public const _TABLE = 'email_links';
    public const ID = 'id';
    public const HASH = 'hash';
    public const ACTION = 'action';
    public const USER_ID = 'user_id';
    public const METADATA = 'metadata';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
}