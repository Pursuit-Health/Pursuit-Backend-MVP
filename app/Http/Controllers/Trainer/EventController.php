<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/13/17
 * Time: 14:53
 */

namespace App\Http\Controllers\Trainer;


use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Relations\ClientRelations;
use App\Models\Relations\EventRelations;
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
            ->with([
                EventRelations::CLIENTS . '.' . ClientRelations::USER
            ])
            ->betweenDates($request['start_date'], $request['end_date'])
            ->linkedTrainer()
            ->get();


        return fractal($events, new EventTransformer())
            ->parseIncludes([
                EventRelations::CLIENTS . '.' . ClientRelations::USER
            ])
            ->respond();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            Rules::date(),
            Rules::endAt(),
            Rules::title(),
            Rules::startAt(),
            Rules::clients(),
            Rules::location(),
        ]);

        $event = new Event($request->all());
        $event->setLinkedTrainer();
        $event->save();

        $event->clients()->attach($request['clients']);

        $event->load([
            EventRelations::CLIENTS . '.' . ClientRelations::USER
        ]);

        return fractal($event, new EventTransformer())
            ->parseIncludes([
                EventRelations::CLIENTS . '.' . ClientRelations::USER
            ])
            ->respond();
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            Rules::date(),
            Rules::endAt(),
            Rules::title(),
            Rules::startAt(),
            Rules::clients(),
            Rules::location(),
        ]);


        $event = Event::query()
            ->linkedTrainer()
            ->findOrFail($request['event_id']);


        $event->update($request->all());
        $event->clients()->sync($request['clients']);
        $event->load([
            EventRelations::CLIENTS . '.' . ClientRelations::USER
        ]);


        return fractal($event, new EventTransformer())
            ->parseIncludes([
                EventRelations::CLIENTS . '.' . ClientRelations::USER
            ])
            ->respond();
    }

    public function delete(Request $request)
    {
        $event = Event::query()
            ->linkedTrainer()
            ->findOrFail($request['event_id']);

        $event->delete();
    }
}