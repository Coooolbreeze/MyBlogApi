<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/8/19
 * Time: 23:13
 */

namespace App\Jobs\Timer;


use App\Caches\PostStatisticCache;
use Hhxsv5\LaravelS\Swoole\Timer\CronJob;

class SyncCacheToDatabase extends CronJob
{
    protected $i = 0;

    public function __construct()
    {
    }

    public function interval()
    {
        return 24 * 60 * 60 * 1000;
    }

    public function isImmediate()
    {
        return true;
    }

    /**
     * @throws \App\Exceptions\BaseException
     */
    public function run()
    {
        \Log::info(__METHOD__, ['start', $this->i, microtime(true)]);

        PostStatisticCache::syncToDatabase();

        $this->i++;
        \Log::info(__METHOD__, ['end', $this->i, microtime(true)]);
    }
}