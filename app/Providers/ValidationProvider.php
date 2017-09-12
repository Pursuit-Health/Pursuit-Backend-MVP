<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/11/17
 * Time: 20:54
 */

namespace App\Providers;


use App\Models\Exercise;
use App\Models\Exercises\ExerciseInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ValidationProvider extends ServiceProvider
{
    public function boot()
    {
        app('validator')->extend('exercise', function ($attribute, $value) {
            $class = Exercise::EXERCISES_NAMESPACE . ucfirst(Str::camel($value));
            return class_exists($class) && is_subclass_of($class, ExerciseInterface::class);
        });
    }
}