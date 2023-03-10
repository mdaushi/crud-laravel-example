<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $images = $this->imageService->model::with('products')->get();
            
            return response()->json([
                'status' => true,
                'message' => 'List Image',
                'datas' => $images
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImageRequest $request)
    {
        try {
            $image = $this->imageService->addImage($request);

            return response()->json([
                'status' => true,
                'message' => 'tambah image berhasil',
                'datas' => $image
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
            $image = $this->imageService->showImageById($id);

            return response()->json([
                'status' => true,
                'message' => 'detail image',
                'message' => $image
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}
