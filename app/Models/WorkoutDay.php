<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/20/17
 * Time: 19:54
 */

namespace App\Models;


use App\Models\Contracts\WorkoutDayContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WorkoutDay
 *
 * @property int $id
 * @property int $workout_id
 * @property \Carbon\Carbon $date
 * @mixin Builder
 * @property-read \App\Models\Workout $workout
 */
class WorkoutDay extends Model
{
    public $timestamps = false;
    protected $table = WorkoutDayContract::_TABLE;
    protected $dates = [
        WorkoutDayContract::DATE
    ];

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
}