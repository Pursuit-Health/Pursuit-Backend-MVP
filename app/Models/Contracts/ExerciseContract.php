<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-04
 * Time: 22:42
 */

namespace App\Models\Contracts;


class ExerciseContract
{
    const _TABLE = 'exercises';
    const ID = 'id';
    const NAME = 'name';
    const TEMPLATE_ID = 'template_id';
    const EXERCISABLE_ID = 'exercisable_id';
    const EXERCISABLE_TYPE = 'exercisable_type';
}