<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-08
 * Time: 23:11
 */

namespace App\Transformers;


use App\Models\CountExercise;
use App\Models\Exercise;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class ExerciseTransformer extends TransformerAbstract
{

    public function transform(Exercise $exercise)
    {
        return [
            'id' => $exercise->id,
            'name' => $exercise->name,
            'data' => $exercise->data->toArray(),
            'type' => Str::snake(last(explode('\\', $exercise->type))),
        ];
    }
}