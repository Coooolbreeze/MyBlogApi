<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/7/21
 * Time: 19:56
 */

namespace App\Http\Controllers\Api;


use App\Http\Requests\StorePostTag;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;

class TagController extends ApiController
{
    public function index()
    {
        return $this->success(new TagCollection(Tag::pagination()));
    }

    public function show(Tag $tag)
    {
        return $this->success(new TagResource($tag));
    }

    public function store(StorePostTag $request)
    {
        $tag = Tag::create([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        return $this->success((new TagResource($tag))->show(['id', 'name']));
    }

    public function update(StorePostTag $request, Tag $tag)
    {
        Tag::updateField($request, $tag, ['name', 'color']);

        return $this->updated();
    }

    /**
     * 删除标签
     *
     * @param $id
     * @return mixed
     * @throws \Throwable
     */
    public function destroy($id)
    {
        \DB::transaction(function () use ($id) {
            $tag = Tag::findOrFail($id);
            $tag->posts()->detach();
            $tag->delete();
        });

        return $this->deleted();
    }
}