<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 11/22/17
 * Time: 21:14
 */

namespace App\Models;


use App\Models\Contracts\CategoryContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property int $image_id
 * @property string $name
 * @mixin Builder
 * @method static self query()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exercise[] $exercises
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereImageId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 */
class Category extends Model
{
    public $timestamps = false;
    protected $fillable = [
        CategoryContract::NAME,
        CategoryContract::IMAGE_ID,
    ];


    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }
}