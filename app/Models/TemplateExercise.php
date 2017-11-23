<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 11/22/17
 * Time: 21:06
 */

namespace App\Models;


use App\Models\Contracts\TemplateExerciseContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TemplateExercise
 *
 * @property int $id
 * @property int $template_id
 * @property int|null $exercise_id
 * @property int $type
 * @property string $name
 * @property int $sets
 * @property int $reps
 * @property int $weight
 * @property int $rest
 * @property string|null $notes
 * @mixin Builder
 * @method static self query()
 * @property-read \App\Models\Template $template
 * @property-read \App\Models\Exercise $exercise
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExerciseDay[] $exerciseDays
 */
class TemplateExercise extends Model
{
    public $timestamps = false;
    protected $fillable = [
        TemplateExerciseContract::NAME,
        TemplateExerciseContract::SETS,
        TemplateExerciseContract::REPS,
        TemplateExerciseContract::REST,
        TemplateExerciseContract::TYPE,
        TemplateExerciseContract::NOTES,
        TemplateExerciseContract::WEIGHT,
        TemplateExerciseContract::EXERCISE_ID,
        TemplateExerciseContract::TEMPLATE_ID,
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function exercise()
    {
        return $this->hasOne(Exercise::class);
    }

    public function exerciseDays()
    {
        return $this->hasMany(ExerciseDay::class);
    }
}