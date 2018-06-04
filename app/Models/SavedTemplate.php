<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 5/22/18
 * Time: 17:55
 */

namespace App\Models;


use App\Models\Contracts\SavedTemplateContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\SavedTemplate
 *
 * @property int                      $id
 * @property int                      $trainer_id
 * @property string                   $name
 * @property string|null              $notes
 * @property \Carbon\Carbon           $created_at
 * @property \Carbon\Carbon           $updated_at
 * @property array                    $template
 * @property-read \App\Models\Trainer $trainer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedTemplate whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedTemplate whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedTemplate whereTrainerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedTemplate whereUpdatedAt($value)
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedTemplate linkedTrainer()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedTemplate search($search = null)
 * @method static self query()
 * @method self findOrFail($id, $columns = ['*'])
 */
class SavedTemplate extends Model
{
    protected $table = SavedTemplateContract::_TABLE;

    protected $fillable = [
        SavedTemplateContract::NAME,
        SavedTemplateContract::NOTES,
        SavedTemplateContract::TEMPLATE,
        SavedTemplateContract::TRAINER_ID,
    ];

    protected $casts = [
        SavedTemplateContract::TEMPLATE => 'array',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function scopeLinkedTrainer(Builder $builder)
    {
        /**@var self $builder */
        return $builder->whereTrainerId(Auth::user()->userable_id);
    }

    public function scopeSearch(Builder $builder, $search = null)
    {
        return $builder->when(null !== $search, function ($builder) use ($search) {
            /**@var self $builder */
            return $builder->where(SavedTemplateContract::NAME, 'LIKE', '%' . $search . '%');
        });
    }
}