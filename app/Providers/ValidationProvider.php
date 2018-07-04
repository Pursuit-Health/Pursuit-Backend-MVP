<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/11/17
 * Time: 20:54
 */

namespace App\Providers;


use App\Models\Client;
use App\Validation\SetRule;
use Illuminate\Support\ServiceProvider;

class ValidationProvider extends ServiceProvider
{
    public function boot()
    {
        $validator = app('validator');
        $validator->extend('set', SetRule::class . '@passes');
        $validator->extendImplicit('subscription_type', function ($attribute, $value, $params) {
            if (null === $value) {
                return true;
            }
            $config = config('subscription_plans');
            if (!array_key_exists($value, $config)) {
                return false;
            }

            return Client::acceptedOnly()->whereTrainerId($params[0])->count() < $config[$value];
        });
    }
}