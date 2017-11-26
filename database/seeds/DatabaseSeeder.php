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
        $this->call(EventSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(TrainerSeeder::class);
        $this->call(TemplateSeeder::class);
        $this->call(ExerciseSeeder::class);
    }
}
