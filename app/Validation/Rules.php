<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-07-31
 * Time: 09:50
 */

namespace App\Validation;


use App\Models\Contracts\ClientContract;
use App\Models\Contracts\TemplateContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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

    public static function startDate(): array
    {
        return [
            'field' => 'start_date',
            'rule' => 'required|date'
        ];
    }

    public static function endDate(): array
    {
        return [
            'field' => 'end_date',
            'rule' => 'required|date|after:start_date'
        ];
    }

    public static function date(): array
    {
        return [
            'field' => 'date',
            'rule' => 'required|date_format:Y-m-d|after:yesterday'
        ];
    }

    public static function startAt(): array
    {
        return [
            'field' => 'start_at',
            'rule' => 'required|date_format:H:i'
        ];
    }

    public static function endAt(): array
    {
        return [
            'field' => 'end_at',
            'rule' => 'required|date_format:H:i|after:start_at'
        ];
    }

    public static function location(): array
    {
        return [
            'field' => 'location',
            'rule' => 'required|max:100'
        ];
    }

    public static function clients(): array
    {
        return [
            'field' => 'clients',
            'rule' => [
                'required',
                'array',
                'min:1',
                'max:10',
                Rule::exists(ClientContract::_TABLE, 'id')->where(function ($builder) {
                    /**@var \Illuminate\Database\Eloquent\Builder $builder */
                    return $builder->where(ClientContract::TRAINER_ID, Auth::user()->userable_id);
                })
            ]
        ];
    }

    public static function clientId(): array
    {
        return [
            'field' => 'client_id',
            'rule' => [
                'required',
                'numeric',
                Rule::exists(ClientContract::_TABLE, 'id')->where(function ($builder) {
                    /**@var \Illuminate\Database\Eloquent\Builder $builder */
                    return $builder->where(ClientContract::TRAINER_ID, Auth::user()->userable_id);
                })
            ]
        ];
    }

    public static function templateId(): array
    {
        return [
            'field' => 'template_id',
            'rule' => [
                'required',
                'numeric',
                Rule::exists(TemplateContract::_TABLE, 'id')->where(function ($builder) {
                    /**@var \Illuminate\Database\Eloquent\Builder $builder */
                    return $builder->where(TemplateContract::TRAINER_ID, Auth::user()->userable_id);
                })
            ]
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