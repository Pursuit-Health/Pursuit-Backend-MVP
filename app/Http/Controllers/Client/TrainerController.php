<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 7/6/18
 * Time: 11:49
 */

namespace App\Http\Controllers\Client;


use App\Exceptions\ErrorCodes;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use App\Validation\Rules;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class TrainerController extends Controller
{
    public function change(Request $request)
    {
        if (($id = $request->get('trainer_id')) && ($id = Hashids::decode($id))) {
            $request->offsetSet('trainer_id', $id[0]);
        }

        $this->validate($request, [Rules::trainerId()]);

        /**@var \App\Models\Client $client */
        $client = Auth::user()->client;

        if ($client->status === Client::S_ACCEPTED) {
            return new JsonResponse([
                'code'    => ErrorCodes::TRAINER_ACCEPTED,
                'message' => 'Trainer already accepted your invite.',
            ], 403);
        }

        $client->status     = Client::S_PENDING;
        $client->trainer_id = $id[0];
        $client->save();
    }
    
    public function get(Request $request){
      header('Content-Type: application/json');
      // Convert hash ID to user ID

      $id = Hashids::decode($request->code);

      if(empty($id) || !is_array($id)){
        http_response_code(404);
        die(json_encode(array('error'=>'Trainer Not Found')));
      } else {
        $trainer = User::where('userable_id', $id[0])->get();
        die(json_encode($trainer));
      }

    
      //dd($request->code);
    }
}