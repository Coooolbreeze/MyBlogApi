<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/8/6
 * Time: 22:02
 */

namespace App\Caches;


use App\Models\Link;

class LinkCache
{
    public static function get()
    {
        return \Cache::rememberForever('links', function () {
            return Link::get(['id', 'name', 'url', 'created_at']);
        });
    }

    public static function syncFromDatabase()
    {
        \Cache::forever('links', Link::get(['id', 'name', 'url', 'created_at']));
    }
}