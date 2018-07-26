<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/7/21
 * Time: 20:00
 */

namespace App\Http\Resources;


class TagResourceCollection extends Collection
{
    protected function processCollection($request)
    {
        return $this->collection->map(function (TagResource $resource) use ($request) {
            if (!empty($this->showFields))
                return $resource->show($this->showFields)->toArray($resource);

            return $resource->hide($this->withoutFields)->toArray($resource);
        })->all();
    }
}