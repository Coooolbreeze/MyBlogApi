<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/8/6
 * Time: 2:28
 */

namespace App\Caches;


use App\Jobs\Task\SyncOnePostToES;
use App\Models\Post;
use App\Models\PostStatistic;
use Carbon\Carbon;
use Hhxsv5\LaravelS\Swoole\Task\Task;

/**
 * Class PostStatisticCache
 * @package App\Caches
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic incWatch($postId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic incLike($postId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic incDislike($postId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic incComment($postId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic getWatch($postId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic getLike($postId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic getDislike($postId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic getComment($postId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic setWatch($param1, $param2 = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic setLike($param1, $param2 = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic setDislike($param1, $param2 = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic setComment($param1, $param2 = '')
 */
class PostStatisticCache
{
    /**
     * 文章ID
     *
     * @var
     */
    private $postId;

    /**
     * 缓存标签
     *
     * @var array
     */
    public $tags = ['post', 'statistic'];

    /**
     * PostStatisticCache constructor.
     *
     * @param $postId
     */
    public function __construct($postId)
    {
        $this->postId = $postId;

        array_push($this->tags, $postId);
    }

    /**
     * @param $key
     * @return mixed
     */
    protected function get($key)
    {
        $value = \Cache::tags($this->tags)
            ->rememberForever($key, function () use ($key) {
                return PostStatistic::where('post_id', $this->postId)
                    ->value($key);
            });
        return $value;
    }

    /**
     * @param $key
     */
    protected function inc($key)
    {
        if (!\Cache::tags($this->tags)->has($key)) {
            $this->get($key);
        }
        \Cache::tags($this->tags)->increment($key);

        if (app()->environment() === 'production') {
            Task::deliver(new SyncOnePostToES(Post::find($this->postId)));
        }
    }

    /**
     * @param $key
     * @param $value
     */
    protected function set($key, $value)
    {
        \Cache::tags($this->tags)->forever($key, $value);
    }

    /**
     * @throws \App\Exceptions\BaseException
     */
    public static function syncToDatabase()
    {
        $postStatistics = [];
        PostStatistic::all()->each(function ($postStatistic) use (&$postStatistics) {
            $postStatisticCache = new static($postStatistic->post_id);
            array_push($postStatistics, [
                'id' => $postStatistic->id,
                'watch' => $postStatisticCache->getWatch(),
                'like' => $postStatisticCache->getLike(),
                'dislike' => $postStatisticCache->getDislike(),
                'comment' => $postStatisticCache->getComment(),
                'updated_at' => Carbon::now()
            ]);
        });
        PostStatistic::updateBatch($postStatistics);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        // 获取操作方法
        $prefix = substr($name, 0, 3);
        // 获取操作key
        $key = strtolower(substr($name, 3));
        // 将key添加入参数
        array_unshift($arguments, $key);

        return call_user_func_array(array(__CLASS__, $prefix), $arguments);
    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        // 获取文章ID
        $postId = array_splice($parameters, 0, 1)[0];
        // 获取操作方法
        $prefix = substr($method, 0, 3);
        // 获取操作key
        $key = strtolower(substr($method, 3));
        // 将key添加入参数
        array_unshift($parameters, $key);

        return call_user_func_array(array(new static($postId), $prefix), $parameters);
    }
}