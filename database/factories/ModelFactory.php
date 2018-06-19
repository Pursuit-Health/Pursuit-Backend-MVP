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

use App\Models\Set;

$factory->define(\App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name'     => $faker->name,
        'email'    => $faker->safeEmail,
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
        'name'        => implode(' ', $generator->words()),
        'image_url'   => $generator->imageUrl(),
        'description' => $generator->text(),
    ];
});


$factory->define(\App\Models\Template::class, function (\Faker\Generator $generator) {
    return [
        'name'     => $generator->words(3, true),
        'start_at' => $generator->dateTimeInInterval('-15 days', '+15 days'),
        'notes'    => $generator->text(),
    ];
});

$factory->define(\App\Models\TemplateExercise::class, function (\Faker\Generator $generator) {
    return [
        'type'       => $generator->numberBetween(1, 3),
        'name'       => $generator->words(2, true),
        'rest'       => $generator->numberBetween(1, 10) . ' mins',
        'notes'      => $generator->text(),
        'sets_count' => $generator->numberBetween(1, 10),
    ];
});


$factory->define(\App\Models\ExerciseDay::class, function (\Faker\Generator $generator) {
    return [];
});


$factory->define(\App\Models\Category::class, function (\Faker\Generator $generator) {
    return [
        'name'     => $generator->words(3, true),
        'image_id' => $generator->numberBetween(1, 10),
    ];
});

$factory->define(\App\Models\Event::class, function (\Faker\Generator $generator) {
    $start = $generator->dateTimeBetween('today', '+18 hours');
    return [
        'date'     => $generator->dateTimeBetween('+1 day', '+2 month'),
        'title'    => $generator->title,
        'start_at' => $start,
        'end_at'   => $start->add(new DateInterval('PT' . $generator->numberBetween(0, 3) . 'H' . $generator->numberBetween(0, 59) . 'M')),
        'location' => $generator->address,
    ];
});

$factory->define(Set::class, function (\Faker\Generator $generator) {
    return [
        'weight_min' => $generator->numberBetween(10, 100),
        'weight_max' => $generator->numberBetween(50, 100),
        'reps_max'   => $generator->numberBetween(1, 10),
        'reps_min'   => $generator->numberBetween(1, 20),
    ];
});