<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/11/17
 * Time: 20:54
 */

namespace App\Providers;


use App\Validation\SetRule;
use Illuminate\Support\ServiceProvider;

class ValidationProvider extends ServiceProvider
{
    public function boot()
    {
        app('validator')->extend('set', SetRule::class . '@passes');
    }
}