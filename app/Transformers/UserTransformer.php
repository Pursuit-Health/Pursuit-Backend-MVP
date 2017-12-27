<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-29
 * Time: 18:10
 */

namespace App\Transformers;


use App\Models\Client;
use App\Models\Relations\UserRelations;
use App\Models\Trainer;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public const F_NAME_ONLY = [
        'name',
        'avatar'
    ];

    protected $availableIncludes = [
        UserRelations::CLIENT,
        UserRelations::TRAINER,
        UserRelations::USERABLE,
    ];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'uid' => $user->uid,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar_url,
            'birthday' => $user->birthday->format('Y-m-d'),
        ];
    }

    public function includeUserable(User $user)
    {
        switch ($user->userable_type) {
            case Client::class:
                return $this->item($user->userable, new ClientTransformer(), 'userable');
                break;
            case Trainer::class:
                return $this->item($user->userable, new TrainerTransformer(), 'userable');
                break;
            default:
                throw new \LogicException('Wrong user type');
        }
    }

    public function includeClient(User $user)
    {
        return $this->item($user->client, new ClientTransformer(), 'client');
    }

    public function includeTrainer(User $user)
    {
        return $this->item($user->trainer, new TrainerTransformer(), 'trainer');
    }
}