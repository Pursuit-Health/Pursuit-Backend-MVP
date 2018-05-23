<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 5/22/18
 * Time: 18:27
 */

namespace App\Transformers;


use App\Models\SavedTemplate;
use League\Fractal\TransformerAbstract;

class SavedTemplateTransformer extends TransformerAbstract
{
    public function transform(SavedTemplate $template)
    {
        return [
            'id'        => $template->id,
            'name'      => $template->name,
            'notes'     => $template->notes,
            'exercises' => $template->template,
        ];
    }
}