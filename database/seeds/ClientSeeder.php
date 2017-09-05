<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-08-29
 * Time: 18:43
 */

class ClientSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $trainers = \App\Models\Trainer::all();
        for ($i = 0; $i < 3; $i++) {
            factory(\App\Models\Client::class, $trainers->count())->make()->each(function (\App\Models\Client $client, int $n) use ($trainers) {
                /** @noinspection PhpParamsInspection */
                $client->trainer_id = $trainers->get($n)->id;
                $client->save();
                $client->user()->save(factory(\App\Models\User::class)->make());
            });
        }
    }
}