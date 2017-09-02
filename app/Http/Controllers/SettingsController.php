<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-31
 * Time: 20:22
 */

namespace App\Http\Controllers;


use App\Transformers\UserTransformer;
use App\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function password(Request $request)
    {
        $this->validate($request, [
            Rules::password()
        ]);

        $user = Auth::user();
        $user->password = $request['password'];
        $user->save();
    }

    public function avatar(Request $request)
    {
        $this->validate($request, [
            Rules::avatar()
        ]);

        $disk = Storage::disk();
        $user = Auth::user();

        if ($user->avatar_path !== null) {
            if (!$disk->delete($user->avatar_path)) {
                Log::critical('Can`t delete previous company logo', [
                    'previous_file' => $user->avatar_path,
                    'company_id' => $user->id
                ]);
            }
        }

        $file = $request->file('avatar');

        $path = $file->storePublicly(config('app.avatars_path'));

        $user->avatar_path = $path;
        $user->avatar_url = file_url($path);
        $user->save();

        return fractal($user, new UserTransformer())
            ->respond();
    }
}