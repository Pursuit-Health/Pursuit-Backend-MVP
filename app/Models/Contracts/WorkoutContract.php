<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/20/17
 * Time: 19:18
 */

namespace App\Models\Contracts;


class WorkoutContract
{
    public const _TABLE = 'workouts';
    public const ID = 'id';
    public const CLIENT_ID = 'client_id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const TEMPLATE_ID = 'template_id';

}