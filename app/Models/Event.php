<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-05
 * Time: 17:55
 */

namespace App\Models;


use App\Models\Contracts\EventContract;
use App\Models\Relations\EventRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property int $trainer_id
 * @property string $location
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin Builder
 * @method static self query()
 * @method self findOrFail($id, $columns = ['*'])
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[] $clients
 * @property-read \App\Models\Trainer $trainer
 * @property int $template_id
 * @property \Carbon\Carbon $date
 * @property \Carbon\Carbon $end_at
 * @property \Carbon\Carbon $start_at
 * @property-read \App\Models\Template $template
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Event linkedTrainer()
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereTrainer($id)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Event betweenDates($start, $end)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Event linkedClient()
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereClient($id)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereCreatedAt($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereDate($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereEndAt($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereLocation($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereStartAt($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereTrainerId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereUpdatedAt($value)
 * @property string $title
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event whereTitle($value)
 */
class Event extends Model
{
    protected $table = EventContract::_TABLE;
    protected $fillable = [
        EventContract::DATE,
        EventContract::TITLE,
        EventContract::END_AT,
        EventContract::START_AT,
        EventContract::LOCATION,
        EventContract::TRAINER_ID,
    ];

    public function setLinkedTrainer()
    {
        $this->trainer_id = Auth::user()->userable_id;
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, EventContract::_PIVOT);
    }

    //SCOPES
    public function scopeWhereTrainer(Builder $builder, $id)
    {
        return $builder->where(EventContract::TRAINER_ID, $id);
    }

    public function scopeWhereClient(Builder $builder, $id)
    {
        return $builder->whereHas(EventRelations::CLIENTS, function (Builder $builder) use ($id) {
            $builder->where('client_id', $id);
        });
    }

    public function scopeLinkedClient(Builder $builder)
    {
        /**@var self $builder */
        return $builder->whereClient(Auth::user()->userable_id);
    }

    public function scopeLinkedTrainer(Builder $builder)
    {
        /**@var self $builder */
        return $builder->whereTrainer(Auth::user()->userable_id);
    }

    public function scopeBetweenDates(Builder $builder, $start, $end)
    {
        return $builder->when($start && $end, function (Builder $builder) use ($end, $start) {
            return $builder
                ->where(EventContract::DATE, '>=', $start)
                ->where(EventContract::DATE, '<=', $end);

        });
    }
}