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
        TemplateRelations::EXERCISES
    ];

    public function transform(Template $template)
    {
        return [
            'id' => $template->id,
            'name' => $template->name,
            'time' => $template->time,
            'image_id' => $template->image_id,
        ];
    }

    public function includeExercises(Template $template)
    {
        return $this->collection($template->exercises, new ExerciseTransformer());
    }
}