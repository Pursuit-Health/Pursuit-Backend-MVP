<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-31
 * Time: 14:08
 */

namespace App\Models;


use App\Models\Contracts\EmailLinkContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmailLink
 *
 * @mixin Builder
 * @method static self query()
 * @property int $id
 * @property User $user
 * @property int $user_id
 * @property string $hash
 * @property string $action
 * @property array $metadata
 * @property array $attributes
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLink whereHash($hash)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLink whereAction($action)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLink whereUser($user_id)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLink whereCreatedAt($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLink whereId($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLink whereMetadata($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLink whereUpdatedAt($value)
 * @method \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLink whereUserId($value)
 */
class EmailLink extends Model
{
    protected $table = EmailLinkContract::_TABLE;
    protected $fillable = [
        EmailLinkContract::USER_ID,
        EmailLinkContract::ACTION,
        EmailLinkContract::METADATA,
    ];
    protected $casts = [
        EmailLinkContract::METADATA => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setActionAttribute($value)
    {
        $this->attributes['action'] = $value;
        $this->attributes['hash'] = sha1(time() . random_bytes(120));
    }

    public function scopeWhereHash(Builder $builder, $hash)
    {
        return $builder->where(EmailLinkContract::HASH, $hash);
    }

    public function scopeWhereAction(Builder $builder, $action)
    {
        return $builder->where(EmailLinkContract::ACTION, $action);
    }

    public function scopeWhereUser(Builder $builder, $user_id)
    {
        return $builder->where(EmailLinkContract::USER_ID, $user_id);
    }
}