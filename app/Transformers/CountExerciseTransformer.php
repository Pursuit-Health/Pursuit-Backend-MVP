<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-08
 * Time: 23:17
 */

namespace App\Transformers;


use App\Models\CountExercise;
use League\Fractal\TransformerAbstract;

class CountExerciseTransformer extends TransformerAbstract
{
    public function transform(CountExercise $exercise)
    {
        return [
            'id' => $exercise->id,
            'times' => $exercise->times,
            'count' => $exercise->count,
            'weight' => $exercise->times,
        ];
    }
}