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
            return $this->model::create($input);
        });
    }
}