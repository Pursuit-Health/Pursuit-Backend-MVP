<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-29
 * Time: 18:16
 */

namespace App\Transformers;

use App\Models\Trainer;
use League\Fractal\TransformerAbstract;

class TrainerTransformer extends TransformerAbstract
{
    public function transform(Trainer $trainer)
    {
        return [
            'id' => $trainer->id
        ];
    }
}