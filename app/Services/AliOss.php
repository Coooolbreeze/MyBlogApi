<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/8/2
 * Time: 21:25
 */

namespace App\Services;


use App\Exceptions\BaseException;
use OSS\Core\OssException;
use OSS\OssClient;

class AliOss
{
    private $accessKeyId;
    private $accessKeySecret;
    private $endpoint;
    private $bucket;
    private $ossClient;

    /**
     * AliOss constructor.
     * @throws OssException
     */
    public function __construct()
    {
        $this->accessKeyId = config('aliOss.access_key_id');
        $this->accessKeySecret = config('aliOss.access_key_secret');
        $this->endpoint = config('aliOss.endpoint');
        $this->bucket = config('aliOss.bucket');
        $this->ossClient = $this->createClient();
    }

    /**
     * @return mixed
     * @throws OssException
     */
    private function createClient()
    {
        try {
            return new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
        } catch (OssException $ossException) {
            throw $ossException;
        }
    }

    public function uploadFile($file)
    {
        $file = '../storage/app/public/' . $file;
        return $this->ossClient->uploadFile($this->bucket, $file, $file);
    }
}