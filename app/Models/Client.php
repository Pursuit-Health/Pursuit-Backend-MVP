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
 * App\Models\Client
 *
 * @method static self query()
 * @mixin Builder
 * @property int $trainer_id
 * @property int $id
 * @property User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereTrainer($id)
 */
class Client extends Model
{
    public $timestamps = false;
    protected $fillable = [
        ClientContract::TRAINER_ID
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, ClientContract::_PIVOT);
    }

    //SCOPES
    public function scopeWhereTrainer(Builder $builder, $id)
    {
        return $builder->where(ClientContract::TRAINER_ID, $id);
    }
}
