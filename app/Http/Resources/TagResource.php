<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/7/21
 * Time: 19:25
 */

namespace App\Http\Resources;


use App\Models\Post;

class TagResource extends Resource
{
    public static function collection($resource)
    {
        return tap(new TagResourceCollection($resource), function ($collection) {
            $collection->collects = __CLASS__;
        });
    }

    public function toArray($request)
    {
        return $this->filterFields([
            'id' => $this->id,
            'name' => $this->name,
            'color' => $this->color,
            'posts' => new PostCollection($this->posts()->latest()->paginate(Post::getLimit())),
            'posts_number' => $this->posts()->count(),
            'created_at' => (string)$this->created_at
        ]);
    }
}