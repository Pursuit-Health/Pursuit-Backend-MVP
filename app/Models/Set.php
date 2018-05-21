<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 5/19/18
 * Time: 11:42
 */

namespace App\Models;


use App\Models\Contracts\SetContract;
use App\Models\Contracts\TemplateExerciseContract;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Set
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property int                               $id
 * @property int                               $template_exercise_id
 * @property int                               $weight_min
 * @property int|null                          $weight_max
 * @property int                               $reps_min
 * @property int|null                          $reps_max
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set whereRepsMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set whereRepsMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set whereTemplateExerciseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set whereWeightMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Set whereWeightMin($value)
 * @property-read \App\Models\TemplateExercise $templateExercise
 */
class Set extends Model
{
    public $timestamps = false;
    public $fillable = [
        SetContract::REPS_MAX,
        SetContract::REPS_MIN,
        SetContract::WEIGHT_MAX,
        SetContract::WEIGHT_MIN,
    ];
    protected $table = SetContract::_TABLE;

    public function templateExercise()
    {
        return $this->belongsTo(
            TemplateExercise::class,
            SetContract::TEMPLATE_EXERCISE_ID,
            TemplateExerciseContract::ID,
            'templateExercise'
        );
    }
}