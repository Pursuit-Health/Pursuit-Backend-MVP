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
        'type' => \App\Models\Exercises\CountExercise::class,
        'data' => [
            'count' => $generator->numberBetween(1, 100),
            'weight' => $generator->numberBetween(25, 200),
            'times' => $generator->numberBetween(1, 10),
        ]
    ];
});


$factory->define(\App\Models\Template::class, function (\Faker\Generator $generator) {
    return [
        'name' => implode(' ', $generator->words()),
        'image_id' => $generator->numberBetween(1, 10),
        'time' => $generator->numberBetween(10, 180),
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