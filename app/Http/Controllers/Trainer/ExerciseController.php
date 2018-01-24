<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 11/24/17
 * Time: 16:22
 */

namespace App\Http\Controllers\Trainer;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exercise;
use App\Transformers\CategoryTransformer;
use App\Transformers\ExerciseTransformer;
use App\Validation\Rules;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function getCategories()
    {
        $categories = Category::all();
        return fractal($categories, new CategoryTransformer());
    }

    public function getCategoryById(Request $request)
    {
        $category = Category::query()->findOrFail($request['category_id']);
        return fractal($category, new CategoryTransformer());
    }

    public function getExercises(Request $request)
    {
        $exercises = Exercise::query()->whereCategoryId($request['category_id'])->get();
        return fractal($exercises, new ExerciseTransformer());
    }

    public function search(Request $request)
    {
        $this->validate($request, [Rules::exerciseSearch()]);
        $exercises = Exercise::query()->where('name', 'like', '%' . $request['phrase'] . '%')->get();
        return fractal($exercises, new ExerciseTransformer());
    }
}