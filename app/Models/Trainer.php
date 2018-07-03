<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-29
 * Time: 16:49
 */

namespace App\Models;


use App\Models\Contracts\ClientContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Trainer
 *
 * @property int                                                                       $id
 * @property User                                                                      $user
 * @method static self query()
 * @mixin Builder
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[]        $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[]         $events
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Template[]      $templates
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Trainer whereId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SavedTemplate[] $savedTemplates
 * @property string|null                                                               $sub_type
 * @property string|null                                                               $sub_valid_until
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trainer whereSubType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trainer whereSubValidUntil($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[]        $clientsAll
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[]        $clientsPending
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
        return $this
            ->hasMany(Client::class)
            ->where(ClientContract::STATUS, Client::S_ACCEPTED);
    }

    public function clientsPending()
    {
        return $this
            ->hasMany(Client::class)
            ->where(ClientContract::STATUS, Client::S_PENDING);
    }

    public function clientsAll()
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

    public function savedTemplates()
    {
        return $this->hasMany(SavedTemplate::class);
    }
}