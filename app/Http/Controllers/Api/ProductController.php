<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;

class ProductController extends Controller
{

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $product = $this->productService->model::with('categories', 'images')->get();
            
            return response()->json([
                'status' => true,
                'message' => 'List produk',
                'datas' => $product
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $product = $this->productService->createProduct($request->all());

            return response()->json([
                'status' => true,
                'message' => 'tambah product berhasil',
                'datas' => $product
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $product = $this->productService->showProductbyId($id);

            return response()->json([
                'status' => true,
                'message' => 'detail produk',
                'datas' => $product
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateProductRequest $request)
    {
        try {
            $product = $this->productService->updateProduct($request->all(), $id);

            return response()->json([
                'status' => true,
                'message' => 'edit produk berhasil',
                'datas' => $product
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = $this->productService->deleteProduct($id);

            return response()->json([
                'status' => true,
                'message' => 'hapus produk berhasil',
                'datas' => $product
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        }
    }
}
