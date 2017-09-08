<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 2017-09-07
 * Time: 22:53
 */

namespace App\Transformers;


use App\Models\Template;
use League\Fractal\TransformerAbstract;

class TemplateTransformer extends TransformerAbstract
{
    public function transform(Template $template)
    {
        return [
            'id' => $template->id,
            'name' => $template->name,
            'time' => $template->time,
            'image_id' => $template->image_id,
        ];
    }
}