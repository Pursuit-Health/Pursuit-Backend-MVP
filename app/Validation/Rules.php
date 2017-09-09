<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-07-31
 * Time: 09:50
 */

namespace App\Validation;


class Rules
{
    public static function email(): array
    {
        return [
            'field' => 'email',
            'rule' => 'required|email'
        ];
    }


    public static function uniqueEmail(): array
    {
        return [
            'field' => 'email',
            'rule' => 'required|email|unique:users,email'
        ];
    }


    public static function password(): array
    {
        return [
            'field' => 'password',
            'rule' => 'required|min:8|max:40'
        ];
    }

    public static function name(): array
    {
        return [
            'field' => 'name',
            'rule' => 'required|min:1|max:100'
        ];
    }


    public static function hash(): array
    {
        return [
            'field' => 'hash',
            'rule' => 'required|size:40'
        ];
    }

    public static function birthday(): array
    {
        return [
            'field' => 'birthday',
            'rule' => 'required|date|before:now'
        ];
    }

    public static function scrollable(): array
    {
        return [
            [
                'field' => 'skip',
                'rule' => 'numeric'
            ],
            [
                'field' => 'limit',
                'rule' => 'numeric'
            ]
        ];
    }

    public static function avatar(): array
    {
        return [
            'field' => 'avatar',
            'rule' => 'required|image|mimes:jpeg,png'
        ];
    }

    public static function trainerIdIfClient(): array
    {
        return [
            'field' => 'trainer_id',
            'rule' => 'required_if:user_type,client|exists:trainers,id',
        ];
    }

    public static function imageId(): array
    {
        return [
            'field' => 'image_id',
            'rule' => 'required|numeric'
        ];
    }

    public static function time(): array
    {
        return [
            'field' => 'time',
            'rule' => 'required|numeric'
        ];
    }

    public static function exercises(): array
    {
        return [
            [
                'field' => 'exercises',
                'rule' => 'required|array',
            ],
            [
                'field' => 'exercises.*',
                'rule' => 'required|array'
            ],
            [
                'field' => 'exercises.*.type',
                'rule' => [
                    'required',
                    Rule::in(Exercise::TYPES),
                ]
            ],
            [
                'field' => 'exercises.*.name',
                'rule' => 'required|min:1|max:100',
            ],
            [
                'field' => 'exercises.*.exercisable',
                'rule' => 'required|array'
            ],
            [
                'field' => 'exercises.*.exercisable.count',
                'rule' => 'required|numeric'
            ],
            [
                'field' => 'exercises.*.exercisable.weight',
                'rule' => 'required|numeric'
            ],
            [
                'field' => 'exercises.*.exercisable.times',
                'rule' => 'required|numeric'
            ],

        ];
    }

}