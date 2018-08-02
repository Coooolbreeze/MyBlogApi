<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/7/21
 * Time: 19:00
 */

namespace App\Http\Resources;


class ImageResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'src' => config('aliOss.host') . $this->src
        ];
    }
}