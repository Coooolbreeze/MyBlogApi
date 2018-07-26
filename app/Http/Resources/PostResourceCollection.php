<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/7/21
 * Time: 19:20
 */

namespace App\Http\Resources;


class PostResourceCollection extends Collection
{
    protected function processCollection($request)
    {
        return $this->collection->map(function (PostResource $resource) use ($request) {
            if (!empty($this->showFields))
                return $resource->show($this->showFields)->toArray($resource);

            return $resource->hide($this->withoutFields)->toArray($resource);
        })->all();
    }
}