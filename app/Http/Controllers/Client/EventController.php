<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/21/17
 * Time: 19:29
 */

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Transformers\EventTransformer;
use App\Validation\Rules;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function get(Request $request)
    {
        $this->validate($request, [
            Rules::startDate(),
            Rules::endDate(),
        ]);

        $events = Event::query()
            ->betweenDates($request['start_date'], $request['end_date'])
            ->linkedClient()
            ->get();


        return fractal($events, new EventTransformer())
            ->respond();
    }
}