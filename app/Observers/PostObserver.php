<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/9/21
 * Time: 2:45
 */

namespace App\Observers;


use App\Jobs\Task\SyncOnePostToES;
use App\Models\Post;
use Hhxsv5\LaravelS\Swoole\Task\Task;

class PostObserver
{
    public function saved(Post $post)
    {
        if (app()->environment() === 'production') {
            Task::deliver(new SyncOnePostToES($post));
        }
    }
}