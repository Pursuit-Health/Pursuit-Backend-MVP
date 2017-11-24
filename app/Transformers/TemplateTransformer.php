<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-07
 * Time: 22:53
 */

namespace App\Transformers;


use App\Models\Relations\TemplateRelations;
use App\Models\Template;
use League\Fractal\TransformerAbstract;

class TemplateTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        TemplateRelations::TEMPLATE_EXERCISES,
        TemplateRelations::DONE
    ];

    public function transform(Template $template)
    {
        return [
            'id' => $template->id,
            'name' => $template->name,
            'notes' => $template->notes,
            'start_at' => $template->start_at->timestamp,
        ];
    }

    public function includeTemplateExercises(Template $template)
    {
        return $this->collection($template->templateExercises, new TemplateExerciseTransformer());
    }

    public function includeFinished(Template $template)
    {
        //TODO: refactor
        return $this->item($template->finished, new ValueTransformer());
    }
}