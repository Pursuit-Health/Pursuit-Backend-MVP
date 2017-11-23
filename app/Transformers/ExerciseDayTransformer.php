<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 11/23/17
 * Time: 10:23
 */

namespace App\Transformers;


use App\Models\ExerciseDay;
use League\Fractal\TransformerAbstract;

class ExerciseDayTransformer extends TransformerAbstract
{
    public function transform(ExerciseDay $day)
    {
        return [
            'created_at' => $day->created_at
        ];
    }
}