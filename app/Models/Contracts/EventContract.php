<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-05
 * Time: 17:52
 */

namespace App\Models\Contracts;


class EventContract
{
    const _TABLE = 'events';
    const ID = 'id';
    const DATE = 'date';
    const END_AT = 'end_at';
    const START_AT  = 'start_at';
    const TRAINER_ID = 'trainer_id';
}