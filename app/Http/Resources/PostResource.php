<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/7/21
 * Time: 19:20
 */

namespace App\Http\Resources;


use App\Caches\PostStatisticCache;
use App\Models\Post;

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
        $postStatisticCache = new PostStatisticCache($this->id);

        return $this->filterFields([
            'id' => $this->id,
            'author' => (new UserResource($this->user))->show(['id', 'nickname', 'avatar']),
            'title' => $this->title,
            'image' => new ImageResource($this->image),
            'outline' => $this->outline,
            'detail' => $this->detail,
            'tags' => TagResource::collection($this->tags)->hide(['posts']),
            'watch' => (int)$postStatisticCache->getWatch(),
            'like' => (int)$postStatisticCache->getLike(),
            'dislike' => (int)$postStatisticCache->getDislike(),
            'prev' => $this->where('id', '>', $this->id)
                ->first(['id', 'title']),
            'next' => $this->where('id', '<', $this->id)
                ->orderBy('id', 'desc')
                ->first(['id', 'title']),
            'created_at' => $this->created_at->toDateString(),
            'updated_at' => $this->updated_at->toDateString()
        ]);
    }
}