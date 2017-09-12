<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-04
 * Time: 22:39
 */

namespace App\Models;


use App\Models\Contracts\ExerciseContract;
use App\Models\Exercises\CountExercise;
use App\Models\Exercises\ExerciseInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


/**
 * App\Models\Exercise
 *
 * @mixin Builder
 * @method static self query()
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $template_id
 * @property array $attributes
 * @property Template $template
 * @property CountExercise $data
 */
class Exercise extends Model
{
    const EXERCISES_NAMESPACE = 'App\Models\Exercises\\';

    public $timestamps = false;
    protected $table = ExerciseContract::_TABLE;
    protected $fillable = [
        ExerciseContract::NAME,
        ExerciseContract::TYPE,
        ExerciseContract::DATA,
        ExerciseContract::TEMPLATE_ID,
    ];
    protected $casts = [
        ExerciseContract::DATA => 'array'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function getDataAttribute()
    {
        if (!class_exists($this->type)) {
            throw new \LogicException('Unknown exercise type');
        }

        return new $this->type(json_decode($this->attributes['data'], true));
    }

    public function setTypeAttribute($value)
    {
        $value = ucfirst(Str::camel($value));
        if (strpos($value, static::EXERCISES_NAMESPACE) !== 0) {
            $value = self::EXERCISES_NAMESPACE . $value;
        }

        $this->attributes['type'] = $value;
    }

    public function setDataAttribute($value)
    {
        if ($value instanceof ExerciseInterface) {
            $value = $value->toArray();
        }

        if (!is_array($value)) {
            throw new \LogicException('Wrong exercise data type');
        }

        $this->attributes['data'] = json_encode($value);
    }

}