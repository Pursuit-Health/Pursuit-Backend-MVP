<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 11/24/17
 * Time: 15:28
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;

class ValueTransformer extends TransformerAbstract
{
    public function transform($value)
    {
        return [
            'value' => $value
        ];
    }
}