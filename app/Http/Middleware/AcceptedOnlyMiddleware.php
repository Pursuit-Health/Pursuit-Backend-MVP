<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 7/3/18
 * Time: 08:16
 */

namespace App\Http\Middleware;


use App\Exceptions\ErrorCodes;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AcceptedOnlyMiddleware
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
        if ($user->isClient()) {
            switch ($user->client->status) {
                case 'pending':
                    return new JsonResponse([
                        'message' => 'Your request still in review',
                        'code'    => ErrorCodes::REQUEST_PENDING,
                    ]);

                case 'rejected':
                    return new JsonResponse([
                        'message' => 'Your request was rejected by trainer',
                        'code'    => ErrorCodes::REQUEST_REJECTED,
                    ]);

                case 'accepted':
                    return $next($request);

                default:
                    throw new \LogicException('Unknown status');
            }
        } else {
            return $next($request);
        }
    }
}