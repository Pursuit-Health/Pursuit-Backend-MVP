<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class LoadExercises extends Command
{
    protected $signature = 'database:load';

    protected $description = 'Loads exercises from exercises.csv file to database';

    public function fire()
    {
        $file = 'exercises.csv';
        $f = fopen($file, 'rb');

        $e = collect();
        while (($line = fgetcsv($f)) !== false) {
            $e->push([
                'category' => $line[0],
                'name' => $line[1],
                'description' => $line[2],
                'image_url' => $line[3] ?: null
            ]);
        }

        $e
            ->groupBy('category')
            ->each(function (Collection $exercises, $category_name) {
                $c = Category::query()->create([
                    'image_id' => 1,
                    'name' => $category_name
                ]);


                $c->exercises()->createMany($exercises->all());
            });
    }
}
