<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/8/6
 * Time: 22:36
 */

namespace App\Observers;


use App\Caches\LinkCache;
use App\Models\Link;

class LinkObserver
{
    public function saved(Link $link)
    {
        LinkCache::syncFromDatabase();
    }

    public function deleted(Link $link)
    {
        LinkCache::syncFromDatabase();
    }
}