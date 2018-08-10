<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/8/6
 * Time: 21:58
 */

namespace App\Http\Controllers\Api;


use App\Caches\LinkCache;
use App\Http\Requests\StoreLink;
use App\Http\Requests\UpdateLink;
use App\Models\Link;

class LinkController extends ApiController
{
    public function index()
    {
        return $this->success(LinkCache::get());
    }

    public function store(StoreLink $request)
    {
        Link::create([
            'name' => $request->name,
            'url' => $request->url
        ]);

        return $this->created();
    }
    public function update(UpdateLink $request, Link $link)
    {
        Link::updateField($request, $link, ['name', 'url']);

        return $this->updated();
    }

    public function destroy(Link $link)
    {
        $link->delete();

        return $this->deleted();
    }
}