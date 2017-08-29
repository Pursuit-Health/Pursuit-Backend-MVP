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
    const _TABLE = 'users';
    const ID = 'id';
    const NAME = 'name';
    const EMAIL = 'email';
    const BIRTHDAY = 'birthday';
    const PASSWORD = 'password';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const USERABLE_ID = 'userable_id';
    const USERABLE_TYPE = 'userable_type';

}