<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-04
 * Time: 23:09
 */

namespace App\Models;


use App\Models\Contracts\TemplateContract;
use App\Models\Traits\Scrollable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


/**
 * App\Models\Template
 *
 * @mixin Builder
 * @method static self query()
 * @property int $id
 * @property int $trainer_id
 * @property int $client_id
 * @property string $name
 * @property \Carbon\Carbon $start_at
 * @property string|null $notes
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property void $template_exercises
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exercise[] $exercises
 * @property-read \App\Models\Trainer $trainer
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Template linkedTrainer()
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Template scrollable(\Illuminate\Http\Request $request)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereTrainer($id)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TemplateExercise[] $templateExercises
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereClientId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereCreatedAt($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereName($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereNotes($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereStartAt($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereTrainerId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereUpdatedAt($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Template actualOnly()
 * @property string|null $deleted_at
 * @method bool|null forceDelete()
 * @method \Illuminate\Database\Query\Builder|\App\Models\Template onlyTrashed()
 * @method bool|null restore()
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereDeletedAt($value)
 * @method \Illuminate\Database\Query\Builder|\App\Models\Template withTrashed()
 * @method \Illuminate\Database\Query\Builder|\App\Models\Template withoutTrashed()
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\Template linkedClient()
 * @property-read bool $done
 */
class Template extends Model
{
    use Scrollable, SoftDeletes;

    protected $table = TemplateContract::_TABLE;
    protected $fillable = [
        TemplateContract::NAME,
        TemplateContract::START_AT,
        TemplateContract::CLIENT_ID,
        TemplateContract::TRAINER_ID,
    ];

    protected $casts = [
        TemplateContract::START_AT => 'date',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function templateExercises()
    {
        return $this->hasMany(TemplateExercise::class);
    }

    //SCOPES
    public function scopeWhereTrainer(Builder $builder, $id)
    {
        return $builder->where(TemplateContract::TRAINER_ID, $id);
    }

    public function scopeLinkedTrainer(Builder $builder)
    {
        /**@var self $builder */
        return $builder->whereTrainer(Auth::user()->userable_id);
    }

    public function scopeLinkedClient(Builder $builder)
    {
        /**@var self $builder */
        return $builder->whereClientId(Auth::user()->userable_id);
    }

    public function scopeActualOnly(Builder $builder)
    {
        /**@var self $builder */
        return $builder->whereRaw('NOW() - INTERVAL 15 DAY < start_at');
    }

    public function getDoneAttribute(): bool
    {
        if ($this->templateExercises->isEmpty()) {
            return false;
        }

        $value = true;
        $this->templateExercises->each(function (TemplateExercise $exercise) use (&$value) {
            $value = $value && (bool) $exercise->done;
        });
        return $value;
    }

}