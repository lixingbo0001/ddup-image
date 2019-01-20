<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/22
 * Time: 上午11:37
 */

namespace Ddup\Image\Test;

use Ddup\Image\Font;
use Ddup\Image\Save;
use Ddup\Image\Water;

class WaterTest extends TestCase
{

    public function testWater()
    {
        $src  = __DIR__ . '/Resource/src.jpg';
        $dst  = __DIR__ . '/Resource/qyk_logo.png';
        $dst2 = __DIR__ . '/Resource/0-9-01.png';
        $dst3 = __DIR__ . '/Resource/0-9-02.png';

        $water = new Water($src);
        $water->water($dst, [
            410, 670
        ]);

        $water->water($dst2, [
            820, 420
        ]);

        $water->water($dst3, [
            900, 420
        ]);

        //二维码475,475

        $text = '航空母舰';
        $x    = 360 + ((564 - mb_strlen($text) * 40)) / 2;

        //font 502 1160
        $font = new Font($water, __DIR__ . '/Resource/chinese.ttf');
        $font->font($text, $x, 1160, '#000', 30);

        $save = new Save(__DIR__ . '/Tmp');
        $save->save($font, $src);

        $this->assertEquals(true, true);
    }

}