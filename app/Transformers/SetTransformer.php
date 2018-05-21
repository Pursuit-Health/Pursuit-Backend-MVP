<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 5/21/18
 * Time: 08:32
 */

namespace App\Transformers;


use App\Models\Set;
use League\Fractal\TransformerAbstract;

class SetTransformer extends TransformerAbstract
{
    public function transform(Set $set)
    {
        return [
            'id'         => $set->id,
            'reps_min'   => $set->reps_min,
            'reps_max'   => $set->reps_max,
            'weight_min' => $set->weight_min,
            'weight_max' => $set->weight_max,
        ];
    }
}