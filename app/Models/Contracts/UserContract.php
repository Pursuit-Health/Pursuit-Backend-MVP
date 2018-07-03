<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-29
 * Time: 15:56
 */

namespace App\Models\Contracts;


class UserContract
{
    public const _TABLE = 'users';
    public const ID = 'id';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const BIRTHDAY = 'birthday';
    public const PASSWORD = 'password';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const USERABLE_ID = 'userable_id';
    public const USERABLE_TYPE = 'userable_type';

}