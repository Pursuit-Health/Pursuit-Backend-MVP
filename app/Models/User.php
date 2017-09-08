<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-29
 * Time: 15:55
 */

namespace App\Models;


use App\Models\Contracts\UserContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\User
 *
 * @mixin Builder
 * @method static self query()
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Client $client
 * @property int $userable_id
 * @property string $password
 * @property Trainer $trainer
 * @property array $attributes
 * @property string $user_type
 * @property string $userable_type
 * @property EmailLink $email_link
 * @property \Carbon\Carbon $birthday
 * @property Client|Trainer $userable
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($email)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EmailLink[] $emailLink
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($id)
 * @property string|null $avatar_url
 * @property string|null $avatar_path
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    protected $table = UserContract::_TABLE;
    protected $fillable = [
        UserContract::NAME,
        UserContract::EMAIL,
        UserContract::PASSWORD,
        UserContract::BIRTHDAY,
        UserContract::USERABLE_ID,
        UserContract::USERABLE_TYPE,
    ];
    protected $casts = [
        UserContract::BIRTHDAY => 'date',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        $userable_type = $this->attributes[UserContract::USERABLE_TYPE];
        switch ($userable_type) {
            case Client::class:
                return [
                    'utp' => lcfirst(last(explode('\\', $userable_type)))
                ];
                break;
            case Trainer::class:
                return [
                    'utp' => lcfirst(last(explode('\\', $userable_type)))
                ];
                break;
            default:
                throw new LogicException('Undefined user type');
                break;
        }
    }

    //MUTATORS
    public function setPasswordAttribute($password)
    {
        $this->attributes[UserContract::PASSWORD] = Hash::make($password);
    }

    public function getUserTypeAttribute()
    {
        return lcfirst(last(explode('\\', $this->attributes[UserContract::USERABLE_TYPE])));

    }

    public function userable()
    {
        return $this->morphTo();
    }

    public function client()
    {
        return $this->belongsTo(Client::class, UserContract::USERABLE_ID);

    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, UserContract::USERABLE_ID);
    }

    public function emailLink()
    {
        return $this->hasMany(EmailLink::class);
    }

    //SCOPES
    public function scopeWhereEmail(Builder $builder, $email)
    {
        return $builder->where(UserContract::EMAIL, $email);
    }

    public function scopeWhereId(Builder $builder, $id)
    {
        return $builder->where(UserContract::ID, $id);
    }

}