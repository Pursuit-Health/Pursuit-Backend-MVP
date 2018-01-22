<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/**@var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'birthday' => $faker->dateTimeBetween(),
        'password' => '123456789',
    ];
});

$factory->define(\App\Models\Client::class, function (Faker\Generator $faker) {
    return [

    ];
});

$factory->define(\App\Models\Trainer::class, function (Faker\Generator $faker) {
    return [

    ];
});

$factory->define(\App\Models\Exercise::class, function (\Faker\Generator $generator) {
    return [
        'name' => implode(' ', $generator->words()),
        'image_url' => $generator->imageUrl(),
        'description' => $generator->text()
    ];
});


$factory->define(\App\Models\Template::class, function (\Faker\Generator $generator) {
    return [
        'name' => $generator->words(3, true),
        'start_at' => $generator->dateTimeInInterval('-15 days', '+15 days'),
        'notes' => $generator->text(),
    ];
});

$factory->define(\App\Models\TemplateExercise::class, function (\Faker\Generator $generator) {
    return [
        'type' => $generator->numberBetween(1, 3),
        'name' => $generator->words(2, true),
        'sets' => $generator->numberBetween(1, 10),
        'reps' => $generator->numberBetween(1, 10) . ' mins',
        'weight' => $generator->numberBetween(50, 150),
        'rest' => $generator->numberBetween(1, 10),
        'notes' => $generator->text(),
    ];
});


$factory->define(\App\Models\ExerciseDay::class, function (\Faker\Generator $generator) {
    return [];
});


$factory->define(\App\Models\Category::class, function (\Faker\Generator $generator) {
    return [
        'name' => $generator->words(3, true),
        'image_id' => $generator->numberBetween(1, 10),
    ];
});

$factory->define(\App\Models\Event::class, function (\Faker\Generator $generator) {
    $start = $generator->dateTimeBetween('today', '+18 hours');
    return [
        'date' => $generator->dateTimeBetween('+1 day', '+2 month'),
        'start_at' => $start,
        'end_at' => $start->add(new DateInterval('PT' . $generator->numberBetween(0, 3) . 'H' . $generator->numberBetween(0, 59) . 'M')),
        'location' => $generator->address,
    ];
});