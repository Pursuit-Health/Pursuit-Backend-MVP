<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-05
 * Time: 17:55
 */

namespace App\Models;


use App\Models\Contracts\EventContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $date
 * @property string $end_at
 * @property int $trainer_id
 * @property string $start_at
 * @property string $location
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin Builder
 * @method static self query()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[] $clients
 * @property-read \App\Models\Trainer $trainer
 */
class Event extends Model
{
    protected $table = EventContract::_TABLE;
    protected $fillable = [
        EventContract::DATE,
        EventContract::END_AT,
        EventContract::START_AT,
        EventContract::TRAINER_ID,
    ];
    protected $dates = [
        EventContract::START_AT,
        EventContract::END_AT,
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
}