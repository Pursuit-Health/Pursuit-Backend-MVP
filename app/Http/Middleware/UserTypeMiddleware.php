<?php
/**
 * Created by PhpStorm.
 * User: oleh
 * Date: 14.07.17
 * Time: 17:04
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserTypeMiddleware
{

    /**
     * Verifies user type.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $type = Auth::payload()->get('utp');

        if ($role !== $type) {
            abort(403, 'Your user does not have access to perform this');
        }

        return $next($request);
    }
}