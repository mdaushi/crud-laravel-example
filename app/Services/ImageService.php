<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public ?string $model = Image::class;

    public function addImage($input)
    {
        $path = Storage::disk('public')->put('', $input->file('file'));

        return DB::transaction(function () use($input, $path) {
            return $this->model::create([
                'name' => $input->name,
                'file' => $path,
                'enable' => $input->enable
            ]);
        });
    }

    protected function isFound($id)
    {
        if(!$this->model::where('id', $id)->exists()){
            throw new \Exception('Image not found');
        }
    }

    public function showImageById($id)
    {
        $this->isFound($id);

        return $this->model::with('products')->find($id);
    }

    public function updateImage($input, $id)
    {
        $path = Storage::disk('public')->put('', $input->file('file'));

        return DB::transaction(function () use($input, $path, $id) {
            return $this->model::find($id)->update([
                'name' => $input->name,
                'file' => $path,
                'enable' => $input->enable
            ]);
        });
    }

    public function deleteImage($id)
    {
        $this->isFound($id);

        return $this->model::find($id)->delete();
    }
}