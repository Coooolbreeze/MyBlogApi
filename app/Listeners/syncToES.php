<?php

namespace App\Listeners;

use App\Events\PostSaved;
use App\Jobs\Task\SyncOnePostToES;
use Hhxsv5\LaravelS\Swoole\Task\Task;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class syncToES
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostSaved  $event
     * @return void
     */
    public function handle(PostSaved $event)
    {
        Task::deliver(new SyncOnePostToES($event->post));
    }
}
