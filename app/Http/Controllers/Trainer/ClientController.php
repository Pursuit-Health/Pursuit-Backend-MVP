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
use App\Transformers\ClientTransformer;

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
}