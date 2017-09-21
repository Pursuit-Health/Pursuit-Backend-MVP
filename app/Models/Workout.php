<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/20/17
 * Time: 19:46
 */

namespace App\Models;


use App\Models\Contracts\WorkoutContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Workout
 *
 * @property int $id
 * @property int $template_id
 * @property int $client_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property mixed $workout_days
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @method static self query()
 * @property-read \App\Models\Client $client
 * @property-read \App\Models\Template $template
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WorkoutDay[] $workoutDays
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Workout linkedClient()
 * @property-read \App\Models\WorkoutDay $currentWorkoutDay
 */
class Workout extends Model
{
    protected $table = WorkoutContract::_TABLE;
    protected $fillable = [
        WorkoutContract::CLIENT_ID,
        WorkoutContract::TEMPLATE_ID,
    ];

    public function currentWorkoutDay()
    {
        /**@var WorkoutDay $w */
        $w = $this->hasOne(WorkoutDay::class);
        return $w->today();
    }
    
    public function workoutDays()
    {
        return $this->hasMany(WorkoutDay::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    //SCOPES
    public function scopeLinkedClient(Builder $builder)
    {
        return $builder->where(WorkoutContract::CLIENT_ID, Auth::user()->userable_id);
    }
}