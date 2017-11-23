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
    public const _TABLE = 'exercises';
    public const ID = 'id';
    public const NAME = 'name';
    public const IMAGE_URL = 'image_url';
    public const DESCRIPTION = 'description';
    public const CATEGORY_ID = 'category_id';
}