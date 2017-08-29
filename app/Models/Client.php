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
 * App\Models\Client
 *
 * @property int $id
 * @property User $user
 * @mixin Builder
 */
class Client extends Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}