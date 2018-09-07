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
use App\Models\Set;
use App\Models\Template;
use App\Models\TemplateExercise;
use App\Transformers\TemplateTransformer;
use App\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function get(Request $request)
    {
        $templates = Template::query()
            ->whereClientId($request['client_id'])
            ->linkedTrainer()
            ->actualOnly()
            ->with([
                TemplateRelations::DONE,
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::SETS,
            ])
            ->get();

        return fractal($templates, new TemplateTransformer())
            ->parseIncludes([
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::SETS,
                'done',
            ]);
    }

    public function getById(Request $request)
    {
        $template = Template::query()
            ->with([
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::DONE,
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::SETS,
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::EXERCISE,

            ])
            ->actualOnly()
            ->linkedTrainer()
            ->whereClientId($request['client_id'])
            ->findOrFail($request['template_id']);

        return fractal($template, new TemplateTransformer())
            ->parseIncludes([
                'done',
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::DONE,
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::SETS,
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

    public function deleteExercise(Request $request)
    {
        $exercise = TemplateExercise::query()
            ->whereHas('template', function ($builder) use ($request) {
                /**@var \App\Models\Template $builder */
                return $builder
                    ->linkedTrainer()
                    ->whereClientId($request['client_id'])
                    ->whereId($request['template_id']);
            })
            ->findOrFail($request['exercise_id']);

        $exercise->delete();
    }

    public function create(Request $request)
    {
        //TODO: refactor
        $this->validate($request, [
            Rules::name(),
            Rules::notes(),
            Rules::clientId(),
            Rules::exercises(),
            Rules::templateStartAt(),
        ]);

        /**@var array $exercises */
        $ids = Arr::pluck($request['exercises'], 'exercise_id');

        $e = Exercise::query()->findMany($ids, ['id', 'name'])->keyBy('id');

        $template             = new Template($request->all());
        $template->trainer_id = Auth::user()->userable_id;
        $template->save();

        foreach ($exercises as $exercise) {
            $template_ex = new TemplateExercise($exercise);
            if (isset($exercise['exercise_id'])) {
                $template_ex->name = $e[$exercise['exercise_id']]->name;
            }
            $template->templateExercises()->save($template_ex);
            $template_ex->sets()->createMany($exercise['sets']);
        }

        $template->load([
            TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::EXERCISE,
            TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::DONE,
            TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::SETS,
        ]);

        return fractal($template, new TemplateTransformer())
            ->parseIncludes([
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::SETS,
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::DONE,
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::EXERCISE,
            ])
            ->respond();

    }


    public function edit(Request $request)
    {
        //TODO: refactor
        $this->validate($request, [
            Rules::name(),
            Rules::notes(),
            Rules::clientId(),
            Rules::exercisesEdit(),
        ]);

        /**@var Template $template */
        $template = Template::query()
            ->linkedTrainer()
            ->whereClientId($request['client_id'])
            ->findOrFail($request['template_id']);

        $template->name  = $request['name'];
        $template->notes = $request['notes'];
        $template->save();

        /**@var array $exercises */
        $exercises = $request['exercises'];
        $ids       = [];
        foreach ($exercises as $exercise) {
            if (isset($exercise['exercise_id'])) {
                $ids[] = $exercise['exercise_id'];
            }
        }

        $e = Exercise::query()->findMany($ids, ['id', 'name'])->keyBy('id');


        foreach ($exercises as $exercise) {
            if (isset($exercise['id'])) {
                TemplateExercise::query()
                    ->whereId($exercise['id'])
                    ->whereTemplateId($request['template_id'])
                    ->update(
                        collect($exercise)
                            ->only(['name', 'sets_count', 'rest', 'notes', 'type', 'is_weighted', 'is_straight'])
                            ->toArray()
                    );

                Set::whereTemplateExerciseId($exercise['id'])->delete();
                foreach ($exercise['sets'] as $set) {
                    $s                       = new Set($set);
                    $s->template_exercise_id = $exercise['id'];
                    $s->save();
                }
            } else {
                $template_ex = new TemplateExercise($exercise);
                if (isset($exercise['exercise_id'])) {
                    $template_ex->name = $e[$exercise['exercise_id']]->name;
                }
                $template->templateExercises()->save($template_ex);
                $template_ex->sets()->createMany($exercise['sets']);
            }
        }

        $template->load([
            TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::EXERCISE,
            TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::SETS,
            TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::DONE,
        ]);

        return fractal($template, new TemplateTransformer())
            ->parseIncludes([
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::SETS,
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::DONE,
                TemplateRelations::TEMPLATE_EXERCISES . '.' . TemplateExerciseRelations::EXERCISE,
            ])
            ->respond();


    }
}