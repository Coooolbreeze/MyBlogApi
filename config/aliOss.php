<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/8/2
 * Time: 21:15
 */

return [
    /**
     * 阿里OSS域名
     */
    'host' => env('ALI_OSS_HOST'),

    /**
     * 阿里OSS区域
     */
    'endpoint' => env('ALI_OSS_ENDPOINT'),

    /**
     * 阿里OSS accessKey
     */
    'access_key_id' => env('ALI_OSS_ACCESS_KEY_ID'),

    /**
     * 阿里OSS accessKeySecret
     */
    'access_key_secret' => env('ALI_OSS_ACCESS_KEY_SECRET'),

    /**
     * 阿里OSS存储空间
     */
    'bucket' => env('ALI_OSS_BUCKET')
];