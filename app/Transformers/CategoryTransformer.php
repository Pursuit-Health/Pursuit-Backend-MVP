<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 11/23/17
 * Time: 10:29
 */

namespace App\Transformers;


use App\Models\Category;
use App\Models\Relations\CategoryRelations;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        CategoryRelations::EXERCISES
    ];

    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'image_id' => $category->id
        ];
    }

    public function includeExercises(Category $category)
    {
        return $this->collection($category->exercises, new ExerciseTransformer());
    }
}