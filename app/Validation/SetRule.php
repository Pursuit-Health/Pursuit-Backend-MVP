<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 5/21/18
 * Time: 11:51
 */

namespace App\Validation;

class SetRule
{
    public function passes($attribute, $value)
    {
        if (!\is_array($value)) {
            return false;
        }

        switch (\count($value)) {
            case 0:
                return true;
                break;
            case 1:
                return array_has($value, ['reps_min', 'weight_min'])
                    && filter_var($value['reps_min'], FILTER_VALIDATE_INT) !== false
                    && filter_var($value['weight_min'], FILTER_VALIDATE_INT) !== false;
                break;
            default:
                return app()
                    ->make('validator')
                    ->make($value, [
                        'reps_min'   => 'required|integer',
                        'reps_max'   => 'required|integer',
                        'weight_min' => 'required|integer',
                        'weight_max' => 'required|integer',
                    ])
                    ->passes();
        }
    }
}