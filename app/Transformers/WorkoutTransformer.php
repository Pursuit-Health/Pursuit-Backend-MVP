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
        WorkoutRelations::CURRENT_WORKOUT_DAY,
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

    public function includeCurrentWorkoutDay(Workout $workout)
    {
        return $workout->currentWorkoutDay
            ? $this->item($workout->currentWorkoutDay, new WorkoutDayTransformer())
            : $this->null();
    }
}