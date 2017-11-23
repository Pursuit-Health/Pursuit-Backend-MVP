<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-06
 * Time: 09:50
 */

class TemplateSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $trainers = \App\Models\Trainer::query()->with('clients')->get(['id']);
        $trainers->each(function (\App\Models\Trainer $trainer) {
            $trainer->clients->each(function (\App\Models\Client $client) use ($trainer) {
                factory(\App\Models\Template::class, 3)->create(['client_id' => $client->id, 'trainer_id' => $trainer->id])->each(function (\App\Models\Template $template) {
                    factory(\App\Models\TemplateExercise::class, 5)->create(['template_id' => $template->id]);
                });
            });
        });
    }

}