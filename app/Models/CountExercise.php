<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-04
 * Time: 23:03
 */

namespace App\Models;


use App\Models\Contracts\CountExerciseContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CountExercise
 *
 * @property int $id
 * @property int $count
 * @property int $times
 * @property int $weight
 * @property Exercise $exercise
 * @mixin Builder
 */
class CountExercise extends Model
{
    public $timestamps = false;
    protected $table = CountExerciseContract::_TABLE;
    protected $fillable = [
        CountExerciseContract::COUNT,
        CountExerciseContract::TIMES,
        CountExerciseContract::WEIGHT,
    ];

    public function exercise()
    {
        return $this->morphOne(Exercise::class, 'exercisable');
    }
}