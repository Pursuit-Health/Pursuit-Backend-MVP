<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/14/17
 * Time: 21:24
 */

namespace App\Http\Controllers\Trainer;


use App\Exceptions\ErrorCodes;
use App\Http\Controllers\Controller;
use App\Jobs\CreateUserAndDialogInFirebase;
use App\Jobs\DeleteUserAndDialogsInFirebase;
use App\Models\Client;
use App\Models\Workout;
use App\Transformers\ClientTransformer;
use App\Transformers\WorkoutTransformer;
use App\Validation\Rules;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class ClientController extends Controller
{
    public function get()
    {
        $clients = Client::query()
            ->linkedTrainer()
            ->acceptedOnly()
            ->with(['user'])
            ->get();

        return fractal($clients, new ClientTransformer())
            ->parseIncludes(['user'])
            ->respond();
    }

    public function assign(Request $request)
    {
        $this->validate($request, [
            Rules::clientId(),
            Rules::templateId(),
        ]);

        $workout = Workout::query()->firstOrCreate($request->all());

        return fractal($workout, new WorkoutTransformer());
    }

    public function invitaionCode()
    {
        return response()->json([
            'code' => Hashids::encode(Auth::user()->userable_id),
        ]);
    }

    public function pending()
    {
        $clients = Client::query()
            ->linkedTrainer()
            ->pendingOnly()
            ->with(['user'])
            ->get();

        return fractal($clients, new ClientTransformer())
            ->parseIncludes(['user'])
            ->respond();
    }


    public function accept($client_id)
    {
        $user         = Auth::user();
        $trainer      = $user->trainer;
        $plan_clients = config("subscription_plans.{$trainer->sub_type}", 0);
        if ($plan_clients - $trainer->clients()->count() < 0) {
            return new JsonResponse([
                'message' => 'Ypu have reached limit of client for your current plan',
                'code'    => ErrorCodes::PLAN_UPGRADE_NEEDED,
            ], 402);
        }

        /**@var \App\Models\Client $client */
        $client         = $trainer->clientsPending()->findOrFail($client_id);
        $client->status = Client::S_ACCEPTED;
        $client->save();

        dispatch(new CreateUserAndDialogInFirebase($client->user, $user));
    }


    public function reject($client_id)
    {
        /**@var \App\Models\Client $client */
        $client         = Auth::user()->trainer->clientsPending()->findOrFail($client_id);
        $client->status = Client::S_REJECTED;
        $client->save();
    }

    public function delete($client_id)
    {
        /**@var \App\Models\Client $client */
        $trainer        = Auth::user()->trainer;
        $client         = $trainer->clients()->findOrFail($client_id);
        $client->status = Client::S_DELETED;
        $client->save();

        $client->events()->detach();
        $trainer->events()->empty()->delete();

        dispatch(new DeleteUserAndDialogsInFirebase($client->user));
    }
}