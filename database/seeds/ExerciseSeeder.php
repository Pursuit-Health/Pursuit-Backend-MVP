<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 11/23/17
 * Time: 10:51
 */

class ExerciseSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        factory(\App\Models\Category::class, 10)->create()->each(function (\App\Models\Category $category) {
            factory(\App\Models\Exercise::class, random_int(10, 20))->create(['category_id' => $category->id]);
        });
    }
}