<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-29
 * Time: 18:16
 */

namespace App\Transformers;


use App\Models\Client;
use League\Fractal\TransformerAbstract;

class ClientTransformer extends TransformerAbstract
{
    public function transform(Client $client)
    {
        return [
            'id' => $client->id,
            'trainer_id' => $client->trainer_id
        ];
    }
}