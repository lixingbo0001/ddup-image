<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/22
 * Time: 上午10:54
 */

namespace Ddup\Image;


class Font implements Resourceable
{

    private $resouce;
    private $font_file;

    public function __construct(Resourceable $resouce, $font_file)
    {
        $this->resouce   = $resouce;
        $this->font_file = $font_file;
    }

    public function resource():Source
    {
        return $this->resouce->resource();
    }

    private function hexToRgb($colour)
    {

        if ($colour [0] == '#') {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list ($r, $g, $b) = array($colour [0] . $colour [1], $colour [2] . $colour [3], $colour [4] . $colour [5]);
        } elseif (strlen($colour) == 3) {
            list ($r, $g, $b) = array($colour [0] . $colour [0], $colour [1] . $colour [1], $colour [2] . $colour [2]);
        } else {
            return ['r' => 0, 'g' => 0, 'b' => 0];
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return ['r' => $r, 'g' => $g, 'b' => $b];
    }

    public function font($text, $x, $y, $color, $size, $space = 6)
    {
        $len = mb_strlen($text, 'UTF8');
        $src = $this->resource()->resource();

        if (is_string($color)) {
            $color = $this->hexToRgb($color);
        }

        $color = imagecolorallocate($src, $color['r'], $color['g'], $color['b']);

        for ($i = 0; $i < $len; $i++) {
            $offset = $i * ($size + $space);
            imagettftext($src, $size, 0, $x + $offset, $y + $size, $color, $this->font_file, mb_substr($text, $i, 1));
        }

        return $this;
    }
}