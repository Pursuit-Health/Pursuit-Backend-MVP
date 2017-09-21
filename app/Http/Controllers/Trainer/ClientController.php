<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/14/17
 * Time: 21:24
 */

namespace App\Http\Controllers\Trainer;


use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Workout;
use App\Transformers\ClientTransformer;
use App\Transformers\WorkoutTransformer;
use App\Validation\Rules;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function get()
    {
        $clients = Client::query()
            ->linkedTrainer()
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
}