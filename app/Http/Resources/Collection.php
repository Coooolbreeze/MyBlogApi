<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/6/15
 * Time: 11:25
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class Collection extends ResourceCollection
{
    protected $withoutFields = [];
    protected $showFields = [];

    public function toArray($request)
    {
        return $this->processCollection($request);
    }

    public function hide(array $fields)
    {
        $this->withoutFields = $fields;
        return $this;
    }

    public function show(array $fields)
    {
        $this->showFields = $fields;
        return $this;
    }

    abstract protected function processCollection($request);
}