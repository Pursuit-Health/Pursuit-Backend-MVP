<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 11/22/17
 * Time: 21:06
 */

namespace App\Models;


use App\Models\Contracts\SetContract;
use App\Models\Contracts\TemplateExerciseContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TemplateExercise
 *
 * @property int                                                                     $id
 * @property int                                                                     $template_id
 * @property int|null                                                                $exercise_id
 * @property int                                                                     $type
 * @property string                                                                  $name
 * @property string                                                                  $rest
 * @property string|null                                                             $notes
 * @mixin Builder
 * @method static self query()
 * @property-read \App\Models\Template                                               $template
 * @property-read \App\Models\Exercise                                               $exercise
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExerciseDay[] $exerciseDays
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\TemplateExercise whereExerciseId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\TemplateExercise whereId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\TemplateExercise whereName($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\TemplateExercise whereNotes($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\TemplateExercise whereReps($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\TemplateExercise whereRest($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\TemplateExercise whereSets($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\TemplateExercise whereTemplateId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\TemplateExercise whereType($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\TemplateExercise whereWeight($value)
 * @property-read \App\Models\ExerciseDay                                    $done
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Set[] $sets
 * @property int|null                                                        $sets_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TemplateExercise whereSetsCount($value)
 * @property bool                                                            $is_weighted
 * @property bool                                                            $is_straight
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TemplateExercise whereIsStraight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TemplateExercise whereIsWeighted($value)
 */
class TemplateExercise extends Model
{
    public $timestamps = false;
    protected $fillable = [
        TemplateExerciseContract::NAME,
        TemplateExerciseContract::REST,
        TemplateExerciseContract::TYPE,
        TemplateExerciseContract::NOTES,
        TemplateExerciseContract::SETS_COUNT,
        TemplateExerciseContract::IS_STRAIGHT,
        TemplateExerciseContract::IS_WEIGHTED,
        TemplateExerciseContract::EXERCISE_ID,
        TemplateExerciseContract::TEMPLATE_ID,
    ];

    protected $casts = [
        TemplateExerciseContract::IS_WEIGHTED => 'bool',
        TemplateExerciseContract::IS_STRAIGHT => 'bool',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function exerciseDays()
    {
        return $this->hasMany(ExerciseDay::class);
    }

    public function sets()
    {
        return $this->hasMany(
            Set::class,
            SetContract::TEMPLATE_EXERCISE_ID,
            TemplateExerciseContract::ID
        );
    }

    public function done()
    {
        return $this->hasOne(ExerciseDay::class)->where('created_at', Carbon::now()->format('Y-m-d'));
    }
}