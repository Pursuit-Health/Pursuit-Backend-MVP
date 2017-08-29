<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-09
 * Time: 18:58
 */

namespace App\Http\Middleware;


use Illuminate\Http\Request;

class RouterParamsInParamBagMiddleware
{
    /**
     * Adds router params to params bag (get and post params)
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $params = $request->route()[2];
        $request->query->add($params);
        return $next($request);
    }
}