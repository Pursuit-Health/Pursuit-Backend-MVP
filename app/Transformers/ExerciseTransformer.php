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
use App\Models\Relations\ExerciseRelations;
use League\Fractal\TransformerAbstract;

class ExerciseTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        ExerciseRelations::CATEGORY,
        ExerciseRelations::TEMPLATE_EXERCISES,
    ];

    public function transform(Exercise $exercise)
    {
        return [
            'id' => $exercise->id,
            'name' => $exercise->name,
            'image_url' => $exercise->image_url,
            'description' => $exercise->description,
        ];
    }

    public function includeTemplateExercises(Exercise $exercise)
    {
        return $this->collection($exercise->templateExercises, new TemplateExerciseTransformer());
    }
}