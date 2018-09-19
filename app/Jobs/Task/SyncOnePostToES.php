<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/9/20
 * Time: 0:38
 */

namespace App\Jobs\Task;


use App\Models\Post;
use Hhxsv5\LaravelS\Swoole\Task\Task;

class SyncOnePostToES extends Task
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle()
    {
        $data = $this->post->toESArray();
        app('es')->index([
            'index' => 'posts',
            'type' => '_doc',
            'id' => $data['id'],
            'body' => $data
        ]);
    }
}