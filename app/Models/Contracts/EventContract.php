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
    public const _TABLE = 'events';
    public const _PIVOT = 'events_clients_pivot';
    public const ID = 'id';
    public const DATE = 'date';
    public const END_AT = 'end_at';
    public const LOCATION = 'location';
    public const START_AT = 'start_at';
    public const TRAINER_ID = 'trainer_id';
}