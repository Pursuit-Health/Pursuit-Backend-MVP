<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/21/17
 * Time: 18:40
 */

namespace App\Transformers;


use App\Models\WorkoutDay;
use League\Fractal\TransformerAbstract;

class WorkoutDayTransformer extends TransformerAbstract
{
    public function transform(WorkoutDay $day)
    {
        return [
            'id' => $day->id,
            'date' => $day->date->format('Y-m-d')
        ];
    }
}