<?php

namespace ITS\Calculation;

abstract class AbstractCalculation
{
    /**
     * extracts the digits, sign, and length of the operands.
     * @param string $x
     * @param string $y
     * @param string $xDig
     * @param string $yDig
     * @param bool $xNeg
     * @param bool $yNeg
     * @param int $xLen
     * @param int $yLen
     */
    final public function init($x, $y, &$xDig, &$yDig, &$xNeg, &$yNeg, &$xLen, &$yLen)
    {var_dump($x);
        $xNeg = ($x[0] === '-');
        $yNeg = ($y[0] === '-');

        $xDig = $xNeg ? substr($x, 1) : $x;
        $yDig = $yNeg ? substr($y, 1) : $y;

        $xLen = strlen($xDig);
        $yLen = strlen($yDig);
    }

    /**
     *  comparing two non-signed large numbers.
     * @param string $x
     * @param string $y
     * @param int $xLen
     * @param int $yLen
     * @return int [-1, 0, 1]
     */
    public function compareUnsigned($x, $y, $xLen, $yLen)
    {
        if ($xLen > $yLen) return 1;
        if ($xLen < $yLen) return -1;
        for($i=0; $i < $xLen; $i++){
            $xInt = (int)$x[$i];
            $yInt = (int)$y[$i];
            if($xInt > $yInt) return 1;
            if($xInt < $yInt) return -1;
        }
        return 0;
    }

    /**
     * compare two numbers.
     * @param string $x
     * @param string $y
     * @return int [-1, 0, 1]
     */
    public function compare($x, $y)
    {
        $this->init($x, $y, $xDig, $yDig, $xNeg, $yNeg, $xLen, $yLen);

        if ($xNeg && ! $yNeg)  return -1;

        if ($yNeg && ! $xNeg) return 1;

        if ($xLen < $yLen) {
            $result = -1;
        } elseif ($xLen > $yLen) {
            $result = 1;
        } else {
            $result = strcmp($xDig, $yDig);

            if ($result < 0) {
                $result = -1;
            } elseif ($result > 0) {
                $result = 1;
            }
        }

        return $xNeg ? -$result : $result;
    }

    /**
     * negates a number
     * @param string $n
     * @return string
     */
    public function negate($n)
    {
        if ($n === '0') {
            return '0';
        }
        if ($n[0] === '-') {
            return substr($n, 1);
        }
        return '-' . $n;
    }

    abstract public function add($x, $y);
    abstract public function sub($x, $y);
    abstract public function mul($x, $y);
    abstract public function div($x, $y);
    abstract public function power($x, $y);
    abstract public function powerMod($x, $y, $m);
    abstract public function powerModPrim($x, $y, $p);
    abstract public function gcd($x, $y);
    abstract public function eGcd($x, $y);
}