<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/22
 * Time: 上午10:54
 */

namespace Ddup\Image;


use Ddup\Part\Libs\Str;

class Infoable
{
    private $info;
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
        $this->info = $this->getInfo($file);
    }

    private function getInfo($file)
    {
        return $this->parseInfo(getimagesize($file));
    }

    private function parseInfo($info)
    {
        $re         = array();
        $re['type'] = Str::last($info['mime'], '/');
        $re['w']    = $info[0];
        $re['h']    = $info[1];
        return $re;
    }

    public function file()
    {
        return $this->file;
    }

    public function type()
    {
        return $this->info['type'];
    }

    public function w()
    {
        return $this->info['w'];
    }

    public function h()
    {
        return $this->info['h'];
    }
}