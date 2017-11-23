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
 * @property string $created_at
 * @property string $updated_at
 * @property void $template_exercise
 * @mixin Builder
 * @method static self query()
 * @property-read \App\Models\TemplateExercise $templateExercise
 */
class ExerciseDay extends Model
{
    public $timestamps = false;
    protected $fillable = [
        ExerciseDayContract::TEMPLATE_EXERCISE_ID
    ];

    public function templateExercise()
    {
        return $this->belongsTo(TemplateExercise::class);
    }
}