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
use League\Fractal\TransformerAbstract;

class ExerciseTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'exercisable'
    ];

    public function transform(Exercise $exercise)
    {
        return [
            'id' => $exercise->id,
            'name' => $exercise->name,
            'type' => lcfirst(last(explode('\\', $exercise->exercisable_type))),
        ];
    }

    public function includeExercisable(Exercise $exercise)
    {
        switch ($exercise->exercisable_type) {
            case CountExercise::class:
                return $this->item($exercise->exercisable, new CountExerciseTransformer());
                break;
            default:
                throw new \LogicException('Unknown exercisable type');
                break;
        }
    }
}