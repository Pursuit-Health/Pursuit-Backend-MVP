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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[] $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Template[] $templates
 */
class Trainer extends Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function templates()
    {
        return $this->hasMany(Template::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}