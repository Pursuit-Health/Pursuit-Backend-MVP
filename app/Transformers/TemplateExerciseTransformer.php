<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 11/23/17
 * Time: 08:53
 */

namespace App\Transformers;


use App\Models\Relations\TemplateExerciseRelations;
use App\Models\TemplateExercise;
use League\Fractal\TransformerAbstract;

class TemplateExerciseTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        TemplateExerciseRelations::EXERCISE,
        TemplateExerciseRelations::EXERCISE_DAYS,
        TemplateExerciseRelations::DONE,
    ];

    public function transform(TemplateExercise $exercise): array
    {
        return [
            'id' => $exercise->id,
            'type' => $exercise->type,
            'name' => $exercise->name,
            'sets' => $exercise->sets,
            'reps' => $exercise->reps,
            'rest' => $exercise->rest,
            'notes' => $exercise->notes,
            'weight' => $exercise->weight,
        ];
    }

    public function includeExercise(TemplateExercise $exercise)
    {
        if ($exercise->exercise) {
            return $this->item($exercise->exercise, new ExerciseTransformer());
        }

        return $this->null();
    }

    public function includeExerciseDays(TemplateExercise $exercise)
    {
        return $this->collection($exercise->exerciseDays, new ExerciseDayTransformer());
    }

    public function includeDone(TemplateExercise $exercise)
    {
        return $this->item((bool)$exercise->done, new ValueTransformer());
    }
}