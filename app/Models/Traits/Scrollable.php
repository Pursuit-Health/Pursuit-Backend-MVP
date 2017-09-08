<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-07-27
 * Time: 14:20
 */

namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Trait Scrollable
 * @package App\Traits
 * @method self scrollable(Request $request)
 */
trait Scrollable
{
    public function scopeScrollable(Builder $builder, Request $request)
    {
        return $builder
            ->limit($request->input('limit', config('app.items_per_request')))
            ->skip($request->input('skip', 0));
    }
}