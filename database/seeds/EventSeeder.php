<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-06
 * Time: 10:04
 */

class EventSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $trainers = \App\Models\Trainer::all(['id']);
        for ($i = 0; $i < $trainers->count(); $i++) {
            $templates = \App\Models\Template::query()->whereTrainer($trainers->get($i)->id)->limit(3)->get(['id']);
            $clients = \App\Models\Client::query()->whereTrainer($trainers->get($i)->id)->limit(2)->get(['id']);
            factory(\App\Models\Event::class, 3)->make(['trainer_id' => $trainers->get($i)->id])->each(function (\App\Models\Event $event, $n) use ($clients, $templates) {
                $event->template_id = $templates->get($n)->id;
                $event->save();
                $event->clients()->attach($n === 2 ? [$clients->get(0)->id, $clients->get(1)->id] : $clients->get($n)->id);
            });

        }
    }
}