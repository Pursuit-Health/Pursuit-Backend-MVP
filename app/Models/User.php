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
 * @property \Carbon\Carbon $birthday
 * @property Client|Trainer $userable
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($email)
 */
class User extends Model
{
    use Authenticatable, Authorizable;

    protected $table = UserContract::_TABLE;
    protected $fillable = [
        UserContract::EMAIL,
        UserContract::PASSWORD,
        UserContract::NAME,
        UserContract::BIRTHDAY,
        UserContract::USERABLE_TYPE,
        UserContract::USERABLE_ID,
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
        return [];
//        $userable_type = $this->attributes[UserContract::USERABLE_TYPE];
//        switch ($userable_type) {
//            case Client::class:
//                return [];
//                break;
//            case Trainer::class:
//                return [];
//                break;
//            default:
//                throw new LogicException('Undefined user type');
//                break;
//        }
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

    //SCOPES
    public function scopeWhereEmail(Builder $builder, $email)
    {
        return $builder->where(UserContract::EMAIL, $email);
    }

}