<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TrainerSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(ExerciseSeeder::class);
        $this->call(TemplateSeeder::class);
//        $this->call(EventSeeder::class);
    }
}
