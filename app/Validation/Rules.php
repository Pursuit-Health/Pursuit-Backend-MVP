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

}