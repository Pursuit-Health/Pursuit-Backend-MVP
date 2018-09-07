<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 7/4/18
 * Time: 11:41
 */

namespace App\Http\Middleware;


use App\Exceptions\ErrorCodes;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SubscriptionValidMiddleware
{
    /**
     * Verifies user type.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $user = Auth::user();
        if ($user->isTrainer()) {
            $tr = $user->trainer;
            if ($tr->sub_type !== 'free' && $tr->sub_valid_until < new \DateTime()) {
                return new JsonResponse([
                    'message' => 'Your subscription expired',
                    'code'    => ErrorCodes::SUBSCRIPTION_EXPIRED,
                ], 402);
            }
        }

        return $next($request);
    }
}