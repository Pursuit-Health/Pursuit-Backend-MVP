<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-29
 * Time: 17:41
 */

namespace App\Http\Controllers;


use App\Models\User;
use App\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            return response('Wrong email or password!', 401);
        }

        /**@var User $user */
        $user = User::query()
            ->with(['userable'])
            ->whereEmail($request['email'])
            ->first();

        return fractal($user, new UserTransformer())
            ->parseIncludes(['userable'])
            ->addMeta(['token' => $token])
            ->respond();
    }
}