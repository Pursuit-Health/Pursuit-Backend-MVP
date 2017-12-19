<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/20/17
 * Time: 19:23
 */

namespace App\Models\Contracts;


class WorkoutDayContract
{
    public const _TABLE = 'workout_days';
    public const ID = 'id';
    public const DATE = 'date';
    public const WORKOUT_ID = 'workout_id';
    public const TEMPLATE_ID = 'template_id';
}