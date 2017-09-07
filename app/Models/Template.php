<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-04
 * Time: 23:09
 */

namespace App\Models;


use App\Models\Contracts\TemplateContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Template
 *
 * @property int $id
 * @property int $time
 * @property string $name
 * @property int $image_id
 * @property int $trainer_id
 * @property Trainer $trainer
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin Builder
 * @method static self query()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exercise[] $exercises
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereTrainer($id)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 */
class Template extends Model
{
    protected $table = TemplateContract::_TABLE;
    protected $fillable = [
        TemplateContract::NAME,
        TemplateContract::TIME,
        TemplateContract::IMAGE_ID,
        TemplateContract::TRAINER_ID,
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    //SCOPES
    public function scopeWhereTrainer(Builder $builder, $id)
    {
        return $builder->where(TemplateContract::TRAINER_ID, $id);
    }
}