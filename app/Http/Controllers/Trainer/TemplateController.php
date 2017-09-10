<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-07
 * Time: 22:11
 */

namespace App\Http\Controllers\Trainer;


use App\Http\Controllers\Controller;
use App\Models\CountExercise;
use App\Models\Exercise;
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

        $template = new Template($request->all());
        $template->trainer_id = Auth::user()->userable_id;
        $template->save();

        $exercises = $request['exercises'];

        /**@var array $exercises */
        foreach ($exercises as $exercise) {
            /** @noinspection DegradedSwitchInspection */
            switch ($exercise['type']) {
                case 'countExercise':
                    $exr = new CountExercise($exercise['exercisable']);
                    break;
                default:
                    throw new \LogicException('Unknown exercise type');
            }
            $exr->template_id = $template->id;
            $exr->save();

            $e = new Exercise($exercise);
            $e->template_id = $template->id;

            $exr->exercise()->save($e);
        }

        $template->load([
            TemplateRelations::EXERCISES . '.' . ExerciseRelations::EXERCISABLE
        ]);

        return fractal($template, new TemplateTransformer())
            ->parseIncludes([
                TemplateRelations::EXERCISES . '.' . ExerciseRelations::EXERCISABLE
            ])
            ->respond();

    }

    public function edit(Request $request)
    {
        //FIXME: remake full template logic
        $this->validate($request, [
            Rules::name(),
            Rules::time(),
            Rules::imageId(),
            Rules::exercises(),
        ]);

        $this->delete($request);
        return $this->create($request);
    }
}