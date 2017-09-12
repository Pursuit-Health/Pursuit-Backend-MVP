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
        $trainers = \App\Models\Trainer::all(['id']);
        for ($i = 0; $i < $trainers->count(); $i++) {
            factory(\App\Models\Template::class, 5)->make()->each(function (\App\Models\Template $template) use ($i, $trainers) {
                $template->trainer_id = $trainers->get($i)->id;
                $template->save();
                factory(\App\Models\Exercise::class, random_int(2, 6))->create(['template_id' => $template->id]);
            });
        }
    }
}