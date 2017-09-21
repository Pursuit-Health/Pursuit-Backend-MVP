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
    const _TABLE = 'workout_days';
    const ID = 'id';
    const DATE = 'date';
    const WORKOUT_ID = 'workout_id';
    const TEMPLATE_ID = 'template_id';
}