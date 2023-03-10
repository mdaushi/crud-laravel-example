<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    /**
     * turunan query Category
     */
    public ?string $model = Category::class;

    public function createCategory($input)
    {
        return DB::transaction(function () use($input) {
            $category = $this->model::create($input);
            $category->products()->attach($input['products']);
            return $category;
        });
    }

    protected function isFound($id)
    {
        if(!$this->model::where('id', $id)->exists()){
            throw new \Exception('Category not found');
        }
    }

    public function showCategoryById($id)
    {
        $this->isFound($id);

        return $this->model::with('products')->find($id);
    }
}