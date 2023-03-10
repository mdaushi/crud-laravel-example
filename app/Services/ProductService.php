<?php 

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public ?string $model = Product::class;

    public function createProduct($input)
    {
        return DB::transaction(function () use($input) {
            $product = $this->model::create($input);
            $product->categories()->attach($input['categories']);
            $product->images()->attach($input['images']);
        });
    }

    private function isFound($id)
    {
        if (!$this->model::where('id', $id)->exists()) {
            throw new \Exception('Product not found');
        }
    }

    public function showProductbyId(int $id)
    {
        $this->isFound($id);

        return DB::transaction(function () use($id) {
            return $this->model::with('categories', 'images')->find($id);
        });

    }

    public function updateProduct($input, $id)
    {
        $this->isFound($id);

        return DB::transaction(function () use($input, $id) {
            $product = $this->model::find($id);
            $product->update($input);
            $product->categories()->sync($input['categories']);
            $product->images()->sync($input['images']);
        });

    }

    public function deleteProduct($id)
    {
        $this->isFound($id);

        return $this->model::find($id)->delete();
    }
}