<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/20/17
 * Time: 19:54
 */

namespace App\Models;


use App\Models\Contracts\WorkoutDayContract;
use Carbon\Carbon;
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
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\WorkoutDay today()
 */
class WorkoutDay extends Model
{
    public $timestamps = false;
    protected $table = WorkoutDayContract::_TABLE;
    protected $dates = [
        WorkoutDayContract::DATE
    ];
    protected $fillable = [
        WorkoutDayContract::TEMPLATE_ID,
        WorkoutDayContract::WORKOUT_ID,
        WorkoutDayContract::DATE
    ];

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }

    //SCOPES
    public function scopeToday(Builder $builder)
    {
        return $builder->where(WorkoutDayContract::DATE, (new Carbon('now'))->format('Y-m-d'));
    }
}