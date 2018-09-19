<?php

namespace App\Console\Commands\Elasticsearch;

use App\Exceptions\BaseException;
use App\Models\Post;
use Illuminate\Console\Command;

class SyncPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:sync-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将文章数据同步到 Elasticsearch';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 获取 Elasticsearch 对象
        $es = app('es');

        Post::query()
            // 预加载标签，避免 N + 1 问题
            ->with(['tags'])
            // 使用 chunkById 避免一次性加载过多数据
            ->chunkById(100, function ($posts) use ($es) {
                $this->info(sprintf('正在同步 ID 范围为 %s 至 %s 的文章', $posts->first()->id, $posts->last()->id));

                // 初始化请求体
                $req = ['body' => []];
                // 遍历文章
                foreach ($posts as $post) {
                    // 将文章模型转为 Elasticsearch 所用的数组
                    $data = $post->toESArray();

                    $req['body'][] = [
                        'index' => [
                            '_index' => 'posts',
                            '_type'  => '_doc',
                            '_id'    => $data['id'],
                        ],
                    ];
                    $req['body'][] = $data;
                }
                try {
                    // 使用 bulk 方法批量创建
                    $es->bulk($req);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
            });
        $this->info('同步完成');
    }
}
