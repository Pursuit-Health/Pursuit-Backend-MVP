<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 11/22/17
 * Time: 20:42
 */

namespace App\Models\Contracts;


class TemplateExerciseContract
{
    public const _TABLE = 'template_exercises';
    public const ID = 'id';
    public const TYPE = 'type';
    public const NAME = 'name';
    public const REPS = 'reps';
    public const REST = 'rest';
    public const NOTES = 'notes';
    public const WEIGHT = 'weight';
    public const SETS_COUNT = 'sets_count';
    public const IS_STRAIGHT = 'is_straight';
    public const IS_WEIGHTED = 'is_weighted';
    public const TEMPLATE_ID = 'template_id';
    public const EXERCISE_ID = 'exercise_id';
}