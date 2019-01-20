<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/22
 * Time: 上午10:54
 */

namespace Ddup\Image;


class Save
{

    private $dir;

    public function __construct($dir)
    {
        $this->dir = $this->formatDir($dir);
    }

    private function formatDir($dir)
    {
        return rtrim($dir, '/');
    }

    public function mkdir()
    {
        is_dir($this->dir) || mkdir($this->dir);
    }

    public function save(Resourceable $src, $file)
    {
        $resource = $src->resource();
        $info     = $resource->info();
        $fun      = 'image' . $info->type();

        if (!function_exists($fun)) {
            throw new \Exception($fun . '不存在');
        }

        $this->mkdir();

        $fun($resource->resource(), $this->dir . '/' . basename($file));

        $resource->destroy();
    }
}