<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/15/17
 * Time: 19:40
 */

namespace App\Transformers;


use App\Models\Event;
use App\Models\Relations\EventRelations;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        EventRelations::CLIENTS,
        EventRelations::TRAINER,
    ];

    public function transform(Event $event)
    {
        return [
            'id' => $event->id,
            'title' => $event->title,
            'location' => $event->location,
            'date' => $event->date,
            'end_at' => (new \DateTime($event->end_at))->format('H:i'),
            'start_at' => (new \DateTime($event->start_at))->format('H:i'),
        ];
    }

    public function includeClients(Event $event)
    {
        return $this->collection($event->clients, new ClientTransformer());
    }

    public function includeTrainer(Event $event)
    {
        return $this->item($event->trainer, new TrainerTransformer());
    }
}