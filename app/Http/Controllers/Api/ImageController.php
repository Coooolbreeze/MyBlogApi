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
use App\Services\AliOss;
use Illuminate\Http\Request;

class ImageController extends ApiController
{
    /**
     * @param Request $request
     * @return mixed
     * @throws \OSS\Core\OssException
     */
    public function store(Request $request)
    {
        $images = [];
        $paths = [];

        foreach ($request->file() as $file) {
            $src = $file->store('blog', 'public');

            (new AliOss())->uploadFile($src);

            array_push($images, [
                'name' => $file->getClientOriginalName(),
                'src' => $src
            ]);

            array_push($paths, $src);

            \Storage::delete('public/' . $src);
        }

        Image::saveAll($images);

        return $this->success(
            ImageResource::collection(Image::whereIn('src', $paths)->get())
        );
    }
}