<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-31
 * Time: 18:54
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EmailController extends Controller
{
    public function redirect(Request $request)
    {
        $config = config('email_templates.' . Str::camel($request['destination']), false);
        if(!$config){
            throw new HttpException(404);
        }

        return redirect($config['deeplink'] . $request['hash']);
    }
}