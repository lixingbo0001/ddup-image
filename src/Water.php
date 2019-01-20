<?php namespace Ddup\Image;


class Water implements Resourceable
{

    public $src;
    /**
     * @var Source
     */
    private $dst;
    private $positon;

    const left_top      = 'left_top';
    const right_top     = 'right_top';
    const right_bottom  = 'right_bottom';
    const left_bottom   = 'left_bottom';
    const bottom_center = 'bottom_center';
    const center        = 'center';


    public function __construct($src)
    {
        $info      = new Infoable($src);
        $this->src = new Source($info);
    }

    private function source($dst)
    {
        $info = new Infoable($dst);
        return new Source($info);
    }

    private function getPos($pos, Infoable $canvas, Infoable $water)
    {
        switch ($pos) {
            case self::left_top:
                $position['x'] = 0;
                $position['y'] = 0;
                break;
            case self::right_top:
                $position['x'] = $canvas->w() - $water->w();
                $position['y'] = 0;
                break;
            case self::right_bottom:
                $position['x'] = $canvas->w() - $water->w();
                $position['y'] = $canvas->h() - $water->h();
                break;
            case self::left_bottom:
                $position['x'] = 0;
                $position['y'] = $canvas->h() - $water->h();
                break;
            case self::bottom_center:
                $position['x'] = ($canvas->w() - $water->w()) / 2;
                $position['y'] = $canvas->h() - $water->h();
                break;
            case self::center:
                $position['x'] = ($canvas->w() - $water->w()) / 2;
                $position['y'] = ($canvas->h() - $water->h()) / 2;
                break;
            default:
                $position['x'] = $pos[0];
                $position['y'] = $pos[1];
                break;
        }

        return $position;
    }

    private function x()
    {
        return $this->positon['x'];
    }

    private function y()
    {
        return $this->positon['y'];
    }

    private function w()
    {
        return $this->dst->info()->w();
    }

    private function h()
    {
        return $this->dst->info()->h();
    }

    private function position($pos)
    {
        $this->positon = $this->getPos($pos, $this->src->info(), $this->dst->info());
        return $this;
    }

    public function resource():Source
    {
        return $this->src;
    }

    public function water($dst, $pos = self::center)
    {
        $this->dst = $this->source($dst);
        $src       = $this->src->resource();

        $this->position($pos);

        imagecopy($src, $this->dst->resource(), $this->x(), $this->y(), 0, 0, $this->w(), $this->h());
        imagesavealpha($src, true);

        return $this;
    }


}
