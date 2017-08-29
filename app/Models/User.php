<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-29
 * Time: 15:55
 */

namespace App\Models;


use App\Models\Contracts\UserContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Exception\LogicException;

/**
 * App\Models\User
 *
 * @property int $id
 * @property int $userable_id
 * @property string $userable_type
 * @property string $name
 * @property string $email
 * @property string $password
 * @property \Carbon\Carbon $birthday
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property Client|Trainer $userable
 * @property array $attributes
 * @mixin Builder
 */
class User extends Model
{
    protected $table = UserContract::_TABLE;
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
                return [];
                break;
            case Trainer::class:
                return [];
                break;
            default:
                throw new LogicException('Undefined user type');
                break;
        }
    }


    public function userable()
    {
        return $this->morphTo();
    }


    //SCOPES
    public function scopeWhereEmail(Builder $builder, $email)
    {
        return $builder->where(UserContract::EMAIL, $email);
    }

}