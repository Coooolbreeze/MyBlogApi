<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/7/21
 * Time: 19:20
 */

namespace App\Http\Resources;


class PostResource extends Resource
{
    public static function collection($resource)
    {
        return tap(new PostResourceCollection($resource), function ($collection) {
            $collection->collects = __CLASS__;
        });
    }

    public function toArray($request)
    {
        return $this->filterFields([
            'id' => $this->id,
            'author' => (new UserResource($this->user))->show(['id', 'nickname', 'avatar']),
            'title' => $this->title,
            'image' => new ImageResource($this->image),
            'outline' => $this->outline ?: interceptHTML($this->detail),
            'detail' => $this->detail,
            'tags' => TagResource::collection($this->tags)->hide(['posts']),
            'watch' => (int)$this->watch,
            'like' => (int)$this->like,
            'dislike' => (int)$this->dislike,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at
        ]);
    }
}