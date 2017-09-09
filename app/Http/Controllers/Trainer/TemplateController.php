<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-07
 * Time: 22:11
 */

namespace App\Http\Controllers\Trainer;


use App\Http\Controllers\Controller;
use App\Models\Relations\ExerciseRelations;
use App\Models\Relations\TemplateRelations;
use App\Models\Template;
use App\Transformers\TemplateTransformer;
use App\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function get()
    {
        $templates = Template::query()
            ->whereTrainer(Auth::user()->userable_id)
//            ->scrollable($request) TODO: enable this
            ->get();

        return fractal($templates, new TemplateTransformer());
    }

    public function getDetailsById(Request $request)
    {
        $template = Template::query()
            ->with([
                TemplateRelations::EXERCISES . '.' . ExerciseRelations::EXERCISABLE
            ])
            ->whereTrainer(Auth::user()->userable_id)
            ->findOrFail($request['template_id']);

        return fractal($template, new TemplateTransformer())
            ->parseIncludes([
                TemplateRelations::EXERCISES . '.' . ExerciseRelations::EXERCISABLE
            ])
            ->respond();

    }

    public function delete(Request $request)
    {
        /**@var Template $template */
        $template = Template::query()
            ->whereTrainer(Auth::user()->userable_id)
            ->findOrFail($request['template_id']);

        $template->delete();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            Rules::name(),
            Rules::time(),
            Rules::imageId(),
            Rules::exercises(),
        ]);

        $exercises = $request['exercises'];

    }
}