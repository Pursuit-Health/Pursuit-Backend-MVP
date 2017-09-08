<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-07
 * Time: 22:11
 */

namespace App\Http\Controllers\Trainer;


use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Transformers\TrainerTransformer;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function get()
    {
        $templates = Template::query()
            ->whereTrainer(Auth::user()->userable_id)
//            ->scrollable($request) TODO: enable this
            ->get();

        return fractal($templates, new TrainerTransformer());
    }
}