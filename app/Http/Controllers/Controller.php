<?php

namespace App\Http\Controllers;

use App\Validation\Combiner;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    /** @noinspection MoreThanThreeArgumentsInspection
     * @param Request $request
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = []): void
    {
        parent::validate($request, Combiner::combine($rules), $messages, $customAttributes);
    }
}
