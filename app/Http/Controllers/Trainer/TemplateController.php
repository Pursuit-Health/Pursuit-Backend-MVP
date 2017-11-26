<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-07
 * Time: 22:11
 */

namespace App\Http\Controllers\Trainer;


use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Relations\TemplateExerciseRelations;
use App\Models\Relations\TemplateRelations;
use App\Models\Template;
use App\Models\TemplateExercise;
use App\Transformers\TemplateTransformer;
use App\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function get(Request $request)
    {
        $templates = Template::query()
            ->whereClientId($request['client_id'])
            ->linkedTrainer()
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
            ->actualOnly()
            ->linkedTrainer()
            ->whereClientId($request['client_id'])
            ->findOrFail($request['template_id']);

        return fractal($template, new TemplateTransformer())
            ->parseIncludes([
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::DONE,
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::EXERCISE,
            ])
            ->respond();

    }

    public function delete(Request $request)
    {
        /**@var Template $template */
        $template = Template::query()
            ->linkedTrainer()
            ->whereClientId($request['client_id'])
            ->findOrFail($request['template_id']);

        $template->delete();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            Rules::name(),
            Rules::notes(),
            Rules::startAt(),
            Rules::clientId(),
            Rules::exercises(),
        ]);

        /**@var array $exercises */
        $exercises = $request['exercises'];
        $ids = [];
        foreach ($exercises as $exercise) {
            if (isset($exercise['exercise_id'])) {
                $ids[] = $exercise['exercise_id'];
            }
        }

        $e = Exercise::query()->findMany($ids, ['id', 'name'])->keyBy('id');


        $template = new Template($request->all());
        $template->trainer_id = Auth::user()->userable_id;
        $template->save();

        $template_exercises = [];
        foreach ($exercises as $exercise) {
            $template_ex = new TemplateExercise($exercise);
            if (isset($exercise['exercise_id'])) {
                $template_ex->name = $e[$exercise['exercise_id']]->name;
            }
            $template_exercises[] = $template_ex;
        }

        $template->templateExercises()->saveMany($template_exercises);


        $template->load([
            TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::EXERCISE,
            TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::DONE,
        ]);

        return fractal($template, new TemplateTransformer())
            ->parseIncludes([
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::DONE,
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::EXERCISE,
            ])
            ->respond();

    }
}