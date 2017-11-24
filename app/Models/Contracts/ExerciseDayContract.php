<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 11/22/17
 * Time: 20:50
 */

namespace App\Models\Contracts;


class ExerciseDayContract
{
    public const _TABLE = 'exercise_days';
    public const ID = 'id';
    public const CREATED_AT = 'created_at';
    public const TEMPLATE_EXERCISE_ID = 'template_exercise_id';
}