<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-02
 * Time: 21:51
 */

use Vinkla\Hashids\Facades\Hashids;

return [
    'locale'            => 'en',
    'avatars_path'      => '/public/avatars',
    'items_per_request' => 20,
    'aliases'           => [
        Hashids::class => \Hashids\Hashids::class,
    ],
];