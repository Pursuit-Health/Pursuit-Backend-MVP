<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-07-31
 * Time: 14:50
 */

namespace App\Validation;


class Combiner
{
    public static function combine(array $rules): array
    {
        $r = [];
        foreach ($rules as $rule) {
            if (self::contains_array($rule)) {
                /**@var array $rule */
                foreach ($rule as $subRule) {
                    $r[$subRule['field']] = $subRule['rule'];
                }
                continue;
            }

            $r[$rule['field']] = $rule['rule'];
        }

        return $r;
    }

    private static function contains_array(array $array): bool
    {
        foreach ($array as $value) {
            if (!is_array($value)) {
                return false;
            }
        }
        return true;
    }
}