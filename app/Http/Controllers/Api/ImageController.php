<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/7/21
 * Time: 18:57
 */

namespace App\Http\Controllers\Api;


use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends ApiController
{
    public function store(Request $request)
    {
        $images = [];
        $paths = [];
        foreach ($request->file() as $file) {
            $src = $file->store('images', 'public');
            array_push($images, [
                'name' => $file->getClientOriginalName(),
                'src' => $src
            ]);
            array_push($paths, $src);
        }
        Image::saveAll($images);

        return $this->success(
            ImageResource::collection(Image::whereIn('src', $paths)->get())
        );
    }
}