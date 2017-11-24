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
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Client
 *
 * @method static self query()
 * @mixin Builder
 * @property int $trainer_id
 * @property int $id
 * @property User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereTrainer($id)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Client linkedTrainer()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Template[] $templates
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereTrainerId($value)
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

    public function templates()
    {
        return $this->hasMany(Template::class);
    }

    //SCOPES
    public function scopeWhereTrainer(Builder $builder, $id)
    {
        return $builder->where(ClientContract::TRAINER_ID, $id);
    }

    public function scopeLinkedTrainer(Builder $builder)
    {
        /**@var self $builder */
        return $builder->whereTrainer(Auth::user()->userable_id);
    }
}
