<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/21/17
 * Time: 19:51
 */

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;
use App\Models\Contracts\WorkoutDayContract;
use App\Models\Relations\WorkoutRelations;
use App\Models\Workout;
use App\Models\WorkoutDay;
use App\Transformers\WorkoutDayTransformer;
use App\Transformers\WorkoutTransformer;
use App\Validation\Rules;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function get()
    {
        $workouts = Workout::query()
            ->with(WorkoutRelations::CURRENT_WORKOUT_DAY)
            ->linkedClient()
            ->get();

        return fractal($workouts, new WorkoutTransformer())
            ->parseIncludes(WorkoutRelations::CURRENT_WORKOUT_DAY)
            ->respond();
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            Rules::submitWorkoutDay()
        ]);

        $workoutDay = WorkoutDay::query()->create(array_merge(
            $request->all(),
            [WorkoutDayContract::DATE => new Carbon('now')]
        ));


        return fractal($workoutDay, new WorkoutDayTransformer())
            ->respond();
    }
}