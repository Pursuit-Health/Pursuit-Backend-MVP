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
use App\Models\Contracts\WorkoutDayContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Rules
{
    public static function email(): array
    {
        return [
            'field' => 'email',
            'rule'  => 'required|email',
        ];
    }

    public static function emailExists(): array
    {
        return [
            'field' => 'email',
            'rule'  => 'required|email|exists:users,email',
        ];
    }


    public static function uniqueEmail(): array
    {
        return [
            'field' => 'email',
            'rule'  => 'required|email|unique:users,email',
        ];
    }


    public static function password(): array
    {
        return [
            'field' => 'password',
            'rule'  => 'required|string|min:8|max:40',
        ];
    }

    public static function name(): array
    {
        return [
            'field' => 'name',
            'rule'  => 'required|string|min:1|max:100',
        ];
    }

    public static function title(): array
    {
        return [
            'field' => 'title',
            'rule'  => 'required|string|min:1|max:100',
        ];
    }


    public static function hash(): array
    {
        return [
            'field' => 'hash',
            'rule'  => 'required|string|size:40',
        ];
    }

    public static function birthday(): array
    {
        return [
            'field' => 'birthday',
            'rule'  => 'required|date|before:now',
        ];
    }

    public static function scrollable(): array
    {
        return [
            [
                'field' => 'skip',
                'rule'  => 'numeric',
            ],
            [
                'field' => 'limit',
                'rule'  => 'numeric',
            ],
        ];
    }

    public static function avatar(): array
    {
        return [
            'field' => 'avatar',
            'rule'  => 'required|image|mimes:jpeg,png',
        ];
    }

    public static function trainerIdIfClient(): array
    {
        return [
            'field' => 'trainer_id',
            'rule'  => 'required_if:user_type,client|exists:trainers,id',
        ];
    }

    public static function trainerId()
    {
        return [
            'field' => 'trainer_id',
            'rule'  => 'required|integer|exists:trainers,id',
        ];
    }

    public static function imageId(): array
    {
        return [
            'field' => 'image_id',
            'rule'  => 'required|numeric',
        ];
    }

    public static function time(): array
    {
        return [
            'field' => 'time',
            'rule'  => 'required|numeric',
        ];
    }

    public static function startDate(): array
    {
        return [
            'field' => 'start_date',
            'rule'  => 'required|date',
        ];
    }

    public static function endDate(): array
    {
        return [
            'field' => 'end_date',
            'rule'  => 'required|date|after:start_date',
        ];
    }

    public static function date(): array
    {
        return [
            'field' => 'date',
            'rule'  => 'required|date_format:Y-m-d|after:yesterday',
        ];
    }

    public static function endAt(): array
    {
        return [
            'field' => 'end_at',
            'rule'  => 'required|date_format:H:i|after:start_at',
        ];
    }

    public static function location(): array
    {
        return [
            'field' => 'location',
            'rule'  => 'required|max:100',
        ];
    }

    public static function clients(): array
    {
        return [
            'field' => 'clients',
            'rule'  => [
                'required',
                'array',
                'min:1',
                Rule::exists(ClientContract::_TABLE, 'id')->where(function ($builder) {
                    /**@var \Illuminate\Database\Eloquent\Builder $builder */
                    return $builder->where(ClientContract::TRAINER_ID, Auth::user()->userable_id);
                }),
            ],
        ];
    }

    public static function clientId(): array
    {
        return [
            'field' => 'client_id',
            'rule'  => [
                'required',
                'numeric',
                Rule::exists(ClientContract::_TABLE, 'id')->where(function ($builder) {
                    /**@var \Illuminate\Database\Eloquent\Builder $builder */
                    return $builder->where(ClientContract::TRAINER_ID, Auth::user()->userable_id);
                }),
            ],
        ];
    }

    public static function notes(): array
    {
        return [
            'field' => 'notes',
            'rule'  => 'string|max:1000',
        ];
    }

    public static function startAt(): array
    {
        return [
            'field' => 'start_at',
            'rule'  => 'required|date_format:H:i',
        ];
    }

    public static function templateStartAt(): array
    {
        return [
            'field' => 'start_at',
            'rule'  => 'required|date_format:Y-m-d|after_or_equal:today',
        ];
    }

    public static function exerciseSearch(): array
    {
        return [
            'field' => 'phrase',
            'rule'  => 'required|string|max:255',
        ];
    }

    public static function templateId(): array
    {
        return [
            'field' => 'template_id',
            'rule'  => [
                'required',
                'numeric',
                Rule::exists(TemplateContract::_TABLE, 'id')->where(function ($builder) {
                    /**@var \Illuminate\Database\Eloquent\Builder $builder */
                    return $builder->where(TemplateContract::TRAINER_ID, Auth::user()->userable_id);
                }),
            ],
        ];
    }

    public static function exercises(): array
    {
        return [
            [
                'field' => 'exercises',
                'rule'  => 'required|array|min:1|max:20',
            ],
            [
                'field' => 'exercises.*',
                'rule'  => 'required|array',
            ],
            [
                'field' => 'exercises.*.name',
                'rule'  => 'required_without:exercises.*.exercise_id|min:1|max:100',
            ],
            [
                'field' => 'exercises.*.exercise_id',
                'rule'  => 'required_without:exercises.*.name|numeric|exists:exercises,id',
            ],
            [
                'field' => 'exercises.*.is_weighted',
                'rule'  => 'present|boolean',
            ],
            [
                'field' => 'exercises.*.is_straight',
                'rule'  => 'present|boolean',
            ],
            [
                'field' => 'exercises.*.sets',
                'rule'  => 'present|array|set',
            ],
            [
                'field' => 'exercises.*.sets.*',
                'rule'  => 'required|array',
            ],
            [
                'field' => 'exercises.*.sets.*.reps_min',
                'rule'  => 'required|numeric',
            ],
            [
                'field' => 'exercises.*.sets.*.weight_min',
                'rule'  => 'required|numeric',
            ],
            [
                'field' => 'exercises.*.rest',
                'rule'  => 'string|max:255',
            ],
            [
                'field' => 'exercises.*.sets_count',
                'rule'  => 'integer|nullable',
            ],
            [
                'field' => 'exercises.*.notes',
                'rule'  => 'string|max:1000',
            ],
            [
                'field' => 'exercises.*.type',
                'rule'  => [
                    'required',
                    Rule::in([1, 2, 3]),
                ],
            ],
        ];
    }

    public static function exercisesEdit(): array
    {
        //TODO: refactor (combine with create)
        return [
            [
                'field' => 'template_id',
                'rule'  => 'required|numeric',
            ],
            [
                'field' => 'exercises',
                'rule'  => 'required|array|min:1|max:20',
            ],
            [
                'field' => 'exercises.*',
                'rule'  => 'required|array',
            ],
            [
                'field' => 'exercises.*.name',
                'rule'  => 'required_without_all:exercises.*.exercise_id,exercises.*.id|min:1|max:100',
            ],
            [
                'field' => 'exercises.*.id',
                'rule'  => 'required_without_all:exercises.*.exercise_id,exercises.*.name|numeric',
            ],
            [
                'field' => 'exercises.*.exercise_id',
                'rule'  => 'required_without_all:exercises.*.id,exercises.*.name|numeric|exists:exercises,id',
            ],
            [
                'field' => 'exercises.*.is_weighted',
                'rule'  => 'present|boolean',
            ],
            [
                'field' => 'exercises.*.is_straight',
                'rule'  => 'present|boolean',
            ],
            [
                'field' => 'exercises.*.sets',
                'rule'  => 'present|array|set',
            ],
            [
                'field' => 'exercises.*.sets.*',
                'rule'  => 'required|array',
            ],
            [
                'field' => 'exercises.*.sets.*.reps_min',
                'rule'  => 'required|numeric',
            ],
            [
                'field' => 'exercises.*.sets.*.weight_min',
                'rule'  => 'required|numeric',
            ],
            [
                'field' => 'exercises.*.rest',
                'rule'  => 'string|max:255',
            ],
            [
                'field' => 'exercises.*.sets_count',
                'rule'  => 'integer|nullable',
            ],
            [
                'field' => 'exercises.*.notes',
                'rule'  => 'string|max:1000',
            ],
            [
                'field' => 'exercises.*.type',
                'rule'  => [
                    'required',
                    Rule::in([1, 2, 3]),
                ],
            ],
        ];
    }

    public static function submitWorkoutDay(): array
    {
        return [
            'field' => 'workout_id',
            'rule'  => [
                'required',
                'numeric',
                Rule::unique(WorkoutDayContract::_TABLE, WorkoutDayContract::WORKOUT_ID)->where(function ($builder) {
                    /**@var \Illuminate\Database\Eloquent\Builder $builder */
                    $builder->where(WorkoutDayContract::DATE, (new Carbon('now'))->format('Y-m-d'));
                }),
            ],
        ];
    }

    public static function subscription(int $trainer_id)
    {
        return [
            [
                'field' => 'sub_type',
                'rule'  => ['present', "subscription_type:{$trainer_id}", 'string'],
            ],
            [
                'field' => 'sub_valid_until',
                'rule'  => 'required_with:sub_type|date_format:Y-m-d H:i:s|after:now',
            ],
        ];
    }

}