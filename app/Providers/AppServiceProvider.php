<?php

namespace App\Providers;

use App\Models\Link;
use App\Models\Post;
use App\Observers\LinkObserver;
use App\Observers\PostObserver;
use Illuminate\Support\ServiceProvider;
use Elasticsearch\ClientBuilder as ESClientBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Link::observe(LinkObserver::class);
        Post::observe(PostObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        // 注册一个名为 es 的单例
        $this->app->singleton('es', function () {
            // 从配置文件读取 Elasticsearch 服务器列表
            $builder = ESClientBuilder::create()->setHosts(config('database.elasticsearch.hosts'));
            // 如果是开发环境
//            if (app()->environment() === 'local') {
//                // 配置日志，Elasticsearch 的请求和返回数据将打印到日志文件中，方便我们调试
//                $builder->setLogger(app('log')->getMonolog());
//            }

            return $builder->build();
        });
    }
}
