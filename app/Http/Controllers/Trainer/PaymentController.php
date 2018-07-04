<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 7/4/18
 * Time: 11:15
 */

namespace App\Http\Controllers\Trainer;


use App\Http\Controllers\Controller;
use App\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function setSubscription(Request $request)
    {
        $trainer = Auth::user()->trainer;

        $this->validate($request, [Rules::subscription($trainer->id)]);

        $trainer                  = Auth::user()->trainer;
        $trainer->sub_type        = $request['sub_type'];
        $trainer->sub_valid_until = $request['sub_valid_until'];
        $trainer->save();
    }
}