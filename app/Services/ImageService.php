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
}