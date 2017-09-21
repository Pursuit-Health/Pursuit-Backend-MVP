<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/21/17
 * Time: 18:38
 */

namespace App\Transformers;


use App\Models\Relations\WorkoutRelations;
use App\Models\Workout;
use League\Fractal\TransformerAbstract;

class WorkoutTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        WorkoutRelations::CLIENT,
        WorkoutRelations::TEMPLATE,
        WorkoutRelations::WORKOUT_DAYS,
    ];

    public function transform(Workout $workout)
    {
        return [
            'id' => $workout->id,
            'created_at' => $workout->created_at->timestamp
        ];
    }

    public function includeClient(Workout $workout)
    {
        return $this->item($workout->client, new ClientTransformer());
    }

    public function includeTemplate(Workout $workout)
    {
        return $this->item($workout->template, new TemplateTransformer());
    }

    public function includeWorkoutDays(Workout $workout)
    {
        return $this->collection($workout->workoutDays, new WorkoutDayTransformer());
    }
}