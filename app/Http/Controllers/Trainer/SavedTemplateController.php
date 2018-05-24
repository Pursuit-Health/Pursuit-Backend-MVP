<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-07
 * Time: 22:11
 */

namespace App\Http\Controllers\Trainer;


use App\Http\Controllers\Controller;
use App\Models\SavedTemplate;
use App\Transformers\SavedTemplateTransformer;
use App\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedTemplateController extends Controller
{
    public function get(Request $request)
    {
        $templates = SavedTemplate::query()
            ->linkedTrainer()
            ->search($request['search'])
            ->paginate();

        return fractal($templates, new SavedTemplateTransformer());
    }

    public function getById($saved_template_id)
    {
        $template = SavedTemplate::query()
            ->linkedTrainer()
            ->findOrFail($saved_template_id);

        return fractal($template, new SavedTemplateTransformer());

    }

    public function delete($saved_template_id)
    {
        $template = SavedTemplate::query()
            ->linkedTrainer()
            ->findOrFail($saved_template_id);

        $template->delete();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            Rules::name(),
            Rules::notes(),
            Rules::exercises(),
        ]);

        $template             = new SavedTemplate($request->all());
        $template->trainer_id = Auth::user()->userable_id;
        $template->template   = $request['exercises'];
        $template->save();

        return fractal($template, new SavedTemplateTransformer());
    }


    public function update(Request $request, $saved_template_id)
    {
        $this->validate($request, [
            Rules::name(),
            Rules::notes(),
            Rules::exercises(),
        ]);

        $template = SavedTemplate::query()
            ->linkedTrainer()
            ->findOrFail($saved_template_id);

        $template->fill($request->all());
        $template->template = $request['exercises'];
        $template->save();

        return fractal($template, new SavedTemplateTransformer());
    }
}