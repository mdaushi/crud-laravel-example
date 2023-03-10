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
}