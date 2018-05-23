<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 5/22/18
 * Time: 18:00
 */

namespace App\Models\Contracts;


class SavedTemplateContract
{
    public const _TABLE = 'saved_templates';

    public const ID = 'id';
    public const NAME = 'name';
    public const NOTES = 'notes';
    public const TEMPLATE = 'template';
    public const TRAINER_ID = 'trainer_id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
}