<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-29
 * Time: 16:49
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Trainer
 *
 * @property int $id
 * @property User $user
 * @method static self query()
 * @mixin Builder
 */
class Trainer extends Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}