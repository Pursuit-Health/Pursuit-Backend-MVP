<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-29
 * Time: 16:51
 */

namespace App\Models\Contracts;


class ClientContract
{
    public const _TABLE = 'clients';
    public const _PIVOT = 'events_clients_pivot';
    public const ID = 'id';
    public const TRAINER_ID = 'trainer_id';
}