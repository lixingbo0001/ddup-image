<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/22
 * Time: 上午10:54
 */

namespace Ddup\Image;


class Source
{

    private $info;

    private $resource;

    public function __construct(Infoable $info)
    {
        $this->info     = $info;
        $this->resource = $this->open($this->info->file(), $this->info->type());
    }

    private function open($file, $type)
    {
        $fun = 'imagecreatefrom' . $type;
        $img = $fun($file);
        return $img;
    }

    public function info()
    {
        return $this->info;
    }

    public function resource()
    {
        return $this->resource;
    }

    public function destroy()
    {
        is_resource($this->resource()) && imagedestroy($this->resource());
    }

    private function type()
    {
        return $this->info()->type();
    }

    private function showByType()
    {
        $resource = $this->resource();
        $fun      = 'image' . $this->type();

        if (!function_exists($fun)) {
            throw new \Exception($fun . '不存在');
        }

        return $fun($resource);
    }

    public function show()
    {
        header('Content-type:image/' . $this->type());
        $ret = $this->showByType();
        $this->destroy();
        return $ret;
    }

    public function string()
    {
        ob_start();
        $this->showByType();
        $img_string = ob_get_clean();
        return $img_string;
    }
}