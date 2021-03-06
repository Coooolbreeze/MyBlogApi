<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group(function () {
    // 用户注册
    Route::post('/register', 'TokenController@register')->name('tokens.register');
    // 用户登录
    Route::post('/login', 'TokenController@login')->name('tokens.login');
    // 刷新token
    Route::post('/refresh', 'TokenController@refresh')->name('tokens.refresh');

    Route::apiResource('tags', 'TagController')
        ->only(['index', 'show']);

    Route::apiResource('posts', 'PostController')
        ->only(['index', 'show']);
    Route::put('/posts/{id}/watch', 'PostController@watch');
    Route::put('/posts/{id}/like', 'PostController@like');

    Route::apiResource('links', 'LinkController')
        ->only(['index']);

    /**
     * 需登录后访问
     */
    Route::middleware('token')->group(function () {
        // 获取自己的资料
        Route::get('/users/self', 'UserController@self')->name('users.self');

        // 上传图片
        Route::apiResource('images', 'ImageController')
            ->only(['store']);
    });

    /**
     * 需超级管理员权限
     */
    Route::middleware('role:super')->group(function () {
        Route::apiResource('tags', 'TagController')
            ->only(['store', 'update', 'destroy']);

        Route::apiResource('posts', 'PostController')
            ->only(['store', 'update', 'destroy']);

        Route::apiResource('links', 'LinkController')
            ->only(['store', 'update', 'destroy']);
    });

    Route::get('/test', function () {
        return app()->environment();
        $postStatisticCache = new \App\Caches\PostStatisticCache(1);
        $postStatisticCache->incWatch();
        $postStatisticCache->incLike();
        $postStatisticCache->incDislike();
        $postStatisticCache->incComment();
        return makeOrderNo();
    });
});