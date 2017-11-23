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
        TemplateRelations::TEMPLATE_EXERCISES
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

    public function includeExercises(Template $template)
    {
        return $this->collection($template->templateExercises, new TemplateExerciseTransformer());
    }
}