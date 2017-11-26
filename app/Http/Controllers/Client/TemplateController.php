<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-07
 * Time: 22:11
 */

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;
use App\Models\Relations\TemplateExerciseRelations;
use App\Models\Relations\TemplateRelations;
use App\Models\Template;
use App\Models\TemplateExercise;
use App\Transformers\TemplateTransformer;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function get()
    {
        $templates = Template::query()
            ->linkedClient()
            ->actualOnly()
            ->with(TemplateRelations::DONE)
            ->get();

        return fractal($templates, new TemplateTransformer())
            ->parseIncludes('done');
    }

    public function getById(Request $request)
    {
        $template = Template::query()
            ->with([
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::EXERCISE,
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::DONE,
            ])
            ->linkedClient()
            ->actualOnly()
            ->findOrFail($request['template_id']);

        return fractal($template, new TemplateTransformer())
            ->parseIncludes([
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::DONE,
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::EXERCISE,
            ])
            ->respond();

    }

    public function submit(Request $request)
    {
        /**@var Template $template */
        $template = Template::query()
            ->linkedClient()
            ->actualOnly()
            ->findOrFail($request['template_id']);

        /**@var TemplateExercise $template_exercise */
        $template_exercise = $template
            ->templateExercises()
            ->findOrFail($request['template_exercise_id']);

        if (!$template_exercise->done()->exists()) {
            $template_exercise->done()->create([]);
        }
    }
}