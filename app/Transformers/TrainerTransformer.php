<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-29
 * Time: 18:16
 */

namespace App\Transformers;

use App\Models\Relations\TrainerRelations;
use App\Models\Trainer;
use League\Fractal\TransformerAbstract;

class TrainerTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        TrainerRelations::USER
    ];

    public function transform(Trainer $trainer)
    {
        return [
            'id' => $trainer->id
        ];
    }

    public function includeUser(Trainer $trainer)
    {
        return $this->item($trainer->user, new UserTransformer(), 'user');
    }
}