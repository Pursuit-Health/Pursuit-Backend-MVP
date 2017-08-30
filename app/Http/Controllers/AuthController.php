<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-29
 * Time: 17:41
 */

namespace App\Http\Controllers;


use App\Models\Client;
use App\Models\Relations\UserRelations;
use App\Models\Trainer;
use App\Models\User;
use App\Transformers\UserTransformer;
use App\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            Rules::email(),
            Rules::password()
        ]);

        $token = Auth::attempt([
            'email' => $request['email'],
            'password' => $request['password'],
        ]);

        if (!$token) {
            throw new HttpException(401, 'Wrong email or password');
        }

        /**@var User $user */
        $user = User::query()
            ->with([UserRelations::USERABLE])
            ->whereEmail($request['email'])
            ->first();

        return fractal($user, new UserTransformer())
            ->parseIncludes([UserRelations::USERABLE])
            ->addMeta([
                'user_type' => $user->user_type,
                'token' => $token
            ])
            ->respond();
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            Rules::name(),
            Rules::birthday(),
            Rules::password(),
            Rules::uniqueEmail(),
        ]);

        switch ($request['user_type']) {
            case 'client':
                $userable = Client::query()->create();
                break;
            case 'trainer';
                $userable = Trainer::query()->create();
                break;
            default:
                throw new \LogicException('Wrong user type');
        }

        /**@var Client|Trainer $userable */
        /**@var User $user */
        $user = $userable->user()->save(User::query()->create($request->all()));
        $user->load(UserRelations::USERABLE);

        return fractal($user, new UserTransformer())
            ->parseIncludes([UserRelations::USERABLE])
            ->addMeta(['user_type' => $user->user_type])
            ->respond();
    }
}