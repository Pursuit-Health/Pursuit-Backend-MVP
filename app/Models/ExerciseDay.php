<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 11/22/17
 * Time: 21:03
 */

namespace App\Models;


use App\Models\Contracts\ExerciseDayContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExerciseDay
 *
 * @property int $id
 * @property int $template_exercise_id
 * @property void $template_exercise
 * @mixin Builder
 * @method static self query()
 * @property-read \App\Models\TemplateExercise $templateExercise
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\ExerciseDay whereCreatedAt($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\ExerciseDay whereId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\ExerciseDay whereTemplateExerciseId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\ExerciseDay whereUpdatedAt($value)
 * @property \Carbon\Carbon $created_at
 */
class ExerciseDay extends Model
{
    public $timestamps = false;
    protected $fillable = [
        ExerciseDayContract::TEMPLATE_EXERCISE_ID
    ];
    protected $casts = [
        ExerciseDayContract::CREATED_AT => 'date'
    ];

    public function templateExercise()
    {
        return $this->belongsTo(TemplateExercise::class);
    }
}