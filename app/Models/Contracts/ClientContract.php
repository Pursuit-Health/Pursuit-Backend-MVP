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
    const _TABLE = 'clients';
    const _PIVOT = 'events_clients_pivot';
    const ID = 'id';
    const TRAINER_ID = 'trainer_id';
}