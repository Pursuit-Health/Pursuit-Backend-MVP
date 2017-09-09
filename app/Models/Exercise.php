<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-04
 * Time: 22:39
 */

namespace App\Models;


use App\Models\Contracts\ExerciseContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Exercise
 *
 * @property int $id
 * @property string $name
 * @property int $template_id
 * @property Template $template
 * @property int $exercisable_id
 * @property string $exercisable_type
 * @property CountExercise $exercisable
 * @mixin Builder
 * @method static self query()
 */
class Exercise extends Model
{
    const TYPES = [
        'countExercise'
    ];

    public $timestamps = false;
    protected $table = ExerciseContract::_TABLE;
    protected $fillable = [
        ExerciseContract::NAME,
        ExerciseContract::TEMPLATE_ID,
        ExerciseContract::EXERCISABLE_ID,
        ExerciseContract::EXERCISABLE_TYPE,
    ];

    public function exercisable()
    {
        return $this->morphTo();
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}