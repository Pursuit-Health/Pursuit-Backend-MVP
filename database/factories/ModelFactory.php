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