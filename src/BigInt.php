<?php

namespace ITS;

class BigInt extends BigNumber
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add($x, $y)
    {
        if($x === '0') return $x;

        if($y === '0') return $y;

        $this->init($x, $y, $xDig, $yDig, $xNeg, $yNeg, $xLen, $yLen);

        if ($xLen <= $this->maxDigitsAddDiv && $yLen <= $this->maxDigitsAddDiv) {
            return (string) ((int) $x + (int) $y);
        }

        $size = $this->resize($xDig, $yDig, $xLen, $yLen);
        $over = 0;
        $result = '';

        for($i=$size-1; $i >= 0; $i--){
            $sum = (int) $xDig[$i] + (int) $yDig[$i] + $over;

            if($sum >= 10){
                $over = 1;
                $sum -= 10;
            } else {
                $over = 0;
            }

            $result .= $sum;
        }

        if($over !== 0){
            $result .= $over;
        }

        return strrev($result);
    }
}