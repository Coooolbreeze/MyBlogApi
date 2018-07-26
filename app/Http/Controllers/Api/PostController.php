<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/7/21
 * Time: 19:26
 */

namespace App\Http\Controllers\Api;


use App\Http\Requests\StoreBlogPost;
use App\Http\Requests\UpdateBlogPost;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
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
        return $this->success(new PostResource($post));
    }

    public function store(StoreBlogPost $request)
    {
        $post = Post::create([
            'image_id' => $request->image_id,
            'title' => $request->title,
            'user_id' => TokenFactory::getCurrentUID(),
            'outline' => $request->outline,
            'detail' => $request->detail
        ]);

        $post->tags()->attach($request->tags);

        return $this->created();
    }

    public function update(UpdateBlogPost $request, Post $post)
    {
        Post::updateField($request, $post, ['image_id', 'title', 'outline', 'detail']);
        isset($request->tags) && $post->tags()->sync($request->tags);

        return $this->updated();
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return $this->deleted();
    }
}