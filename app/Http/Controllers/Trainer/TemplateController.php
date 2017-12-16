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
            ->linkedTrainer()
//            ->scrollable($request) TODO: enable this
            ->get();

        return fractal($templates, new TemplateTransformer());
    }

    public function getDetailsById(Request $request)
    {
        $template = Template::query()
            ->with([
                TemplateRelations::EXERCISES
            ])
            ->linkedTrainer()
            ->findOrFail($request['template_id']);

        return fractal($template, new TemplateTransformer())
            ->parseIncludes([
                TemplateRelations::EXERCISES
            ])
            ->respond();

    }

    public function delete(Request $request)
    {
        /**@var Template $template */
        $template = Template::query()
            ->linkedTrainer()
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

        $template = new Template($request->all());
        $template->trainer_id = Auth::user()->userable_id;
        $template->save();

        $exercises = $request['exercises'];

        $e = [];

        /**@var array $exercises */
        foreach ($exercises as $exercise) {
            $e[] = new Exercise($exercise);
        }

        $template->exercises()->saveMany($e);

        $template->load([
            TemplateRelations::EXERCISES
        ]);

        return fractal($template, new TemplateTransformer())
            ->parseIncludes([
                TemplateRelations::EXERCISES
            ])
            ->respond();

    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            Rules::name(),
            Rules::time(),
            Rules::imageId(),
            Rules::exercises(),
        ]);

        /**@var Template $template */
        $template = Template::query()
            ->linkedTrainer()
            ->findOrFail($request['template_id']);

        $template->update($request->all());

        $template->exercises()->delete();

        $exercises = $request['exercises'];

        $e = [];
        /**@var array $exercises */
        foreach ($exercises as $exercise) {
            $e[] = new Exercise($exercise);
        }

        $template->exercises()->saveMany($e);

        $template->load([
            TemplateRelations::EXERCISES
        ]);

        return fractal($template, new TemplateTransformer())
            ->parseIncludes([
                TemplateRelations::EXERCISES
            ])
            ->respond();

    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            Rules::name(),
            Rules::notes(),
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

        /**@var Template $template */
        $template = Template::query()->findOrFail($request['template_id']);
        $template->name = $request['name'];
        $template->notes = $request['notes'];
        $template->save();

        $template_exercises = [];
        foreach ($exercises as $exercise) {
            $template_ex = new TemplateExercise($exercise);
            if (isset($exercise['exercise_id'])) {
                $template_ex->name = $e[$exercise['exercise_id']]->name;
            }
            $template_exercises[] = $template_ex;
        }

        $template->templateExercises()->delete();
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