<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Link::saveAll([
            ['id' => 1, 'name' => '幕课网', 'url' => 'https://www.imooc.com/'],
            ['id' => 2, 'name' => 'Laravel China', 'url' => 'https://laravel-china.org/'],
            ['id' => 3, 'name' => '小楼昨夜又秋风', 'url' => 'https://zhuanlan.zhihu.com/oldtimes'],
            ['id' => 4, 'name' => '曼巴童鞋', 'url' => 'https://blog.kesixin.xin/']
        ]);
    }
}
