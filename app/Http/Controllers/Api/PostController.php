<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/7/21
 * Time: 19:26
 */

namespace App\Http\Controllers\Api;


use App\Caches\PostStatisticCache;
use App\Http\Requests\StoreBlogPost;
use App\Http\Requests\UpdateBlogPost;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\PostStatistic;
use App\Services\Tokens\TokenFactory;
use Illuminate\Http\Request;

class PostController extends ApiController
{
    public function index(Request $request)
    {
        $posts = (new Post())
            ->when($request->title, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->title . '%');
            })
            ->when($request->sort, function ($query) use ($request) {
                $query->orderBy($request->sort, 'desc');
            })
            ->latest()
            ->paginate(Post::getLimit());

        return $this->success(new PostCollection($posts));
    }

    public function show(Post $post)
    {
        PostStatisticCache::incWatch($post->id);
        return $this->success(new PostResource($post));
    }

    public function watch($id)
    {
        PostStatisticCache::incWatch($id);
    }

    public function like($id)
    {
        PostStatisticCache::incLike($id);
    }

    /**
     * @param StoreBlogPost $request
     * @return mixed
     * @throws \Throwable
     */
    public function store(StoreBlogPost $request)
    {
        \DB::transaction(function () use ($request) {
            $post = Post::create([
                'user_id' => TokenFactory::getCurrentUID(),
                'image_id' => $request->image_id,
                'title' => $request->title,
                'outline' => $request->outline,
                'detail' => $request->detail
            ]);
            $post->tags()->attach($request->tags);
            PostStatistic::create(['post_id' => $post->id]);
        });

        return $this->created();
    }

    public function update(UpdateBlogPost $request, Post $post)
    {
        Post::updateField($request, $post, ['image_id', 'title', 'outline', 'detail']);
        isset($request->tags) && $post->tags()->sync($request->tags);

        return $this->updated();
    }

    /**
     * @param Post $post
     * @return mixed
     * @throws \Throwable
     */
    public function destroy(Post $post)
    {
        \DB::transaction(function () use ($post) {
            $post->delete();
            PostStatistic::where('post_id', $post->id)->delete();
        });

        return $this->deleted();
    }
}