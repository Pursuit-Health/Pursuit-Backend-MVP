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
        factory(\App\Models\Client::class, 50)->create()->each(function (\App\Models\Client $client) {
            /** @noinspection PhpParamsInspection */
            $client->user()->save(factory(\App\Models\User::class)->make());
        });
    }
}