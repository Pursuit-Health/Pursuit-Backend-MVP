<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-05
 * Time: 17:47
 */

namespace App\Models\Contracts;


class TemplateContract
{
    public const _TABLE = 'templates';
    public const ID = 'id';
    public const TIME = 'time';
    public const NAME = 'name';
    public const IMAGE_ID = 'image_id';
    public const TRAINER_ID = 'trainer_id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
}