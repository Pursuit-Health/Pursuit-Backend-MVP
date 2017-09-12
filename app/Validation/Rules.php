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
        return array_merge(
            [
                [
                    'field' => 'exercises',
                    'rule' => 'required|array|min:1|max:10',
                ],
                [
                    'field' => 'exercises.*',
                    'rule' => 'required|array|size:3'
                ],

                [
                    'field' => 'exercises.*.name',
                    'rule' => 'required|min:1|max:100',
                ],
                [
                    'field' => 'exercises.*.type',
                    'rule' => 'required|exercise',
                ],
            ],
            static::countExercise()
        );
    }

    protected static function countExercise(): array
    {
        return [
            [
                'field' => 'exercises.*.data',
                'rule' => 'required|array|size:3'
            ],
            [
                'field' => 'exercises.*.data.count',
                'rule' => 'required|numeric'
            ],
            [
                'field' => 'exercises.*.data.weight',
                'rule' => 'required|numeric'
            ],
            [
                'field' => 'exercises.*.data.times',
                'rule' => 'required|numeric'
            ],
        ];
    }

}