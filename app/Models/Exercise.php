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
 * @mixin Builder
 * @method static self query()
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $image_url
 * @property string $description
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TemplateExercise[] $templateExercises
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereCategoryId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereDescription($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereImageUrl($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Exercise whereName($value)
 */
class Exercise extends Model
{
    public $timestamps = false;
    protected $table = ExerciseContract::_TABLE;
    protected $fillable = [
        ExerciseContract::NAME,
        ExerciseContract::IMAGE_URL,
        ExerciseContract::DESCRIPTION,
        ExerciseContract::CATEGORY_ID,
    ];

    public function templateExercises()
    {
        return $this->hasMany(TemplateExercise::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}