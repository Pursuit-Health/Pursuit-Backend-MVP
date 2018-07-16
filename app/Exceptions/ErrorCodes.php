<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 7/3/18
 * Time: 16:36
 */

namespace App\Exceptions;


class ErrorCodes
{
    public const REQUEST_PENDING = 10001;
    public const REQUEST_REJECTED = 10002;
    public const PLAN_UPGRADE_NEEDED = 10003;
    public const SUBSCRIPTION_EXPIRED = 10004;
    public const TRAINER_ACCEPTED = 10005;
    public const REQUEST_DELETED = 10006;
}