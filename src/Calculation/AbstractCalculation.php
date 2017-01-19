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
    {
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

    /**
     * get the absolute value of a number.
     * @param $n
     * @return string
     */
    public function absolute($n)
    {
        return ($n[0] === '-') ? substr($n, 1) : $n;
    }

    /**
     * addition calculation
     * @param string $x
     * @param string $y
     * @return string
     */
    abstract public function add($x, $y);

    /**
     * subtracts calculation
     * @param string $x
     * @param string $y
     * @return string
     */
    abstract public function sub($x, $y);

    /**
     * multiplies calculation
     * @param string $x
     * @param string $y
     * @return string
     */
    abstract public function mul($x, $y);

    /**
     * division calculation and return quotient and remainder
     * @param string $x
     * @param string $y
     * @return array [quotient, remainder]
     */
    abstract public function div($x, $y);

    /**
     * exponentiation a number.
     * @param string $x
     * @param int $y
     * @return string
     */
    abstract public function power($x, $y);

    /**
     * exponentiation modulo
     * @param string $x
     * @param int $y
     * @param int $m
     * @return string
     */
    abstract public function powerMod($x, $y, $m);

    /**
     * power modulo prime calculation
     * @param string $x
     * @param int $y
     * @param string $p
     * @return string
     */
    abstract public function powerModPrim($x, $y, $p);

    /**
     * euclidean calculation
     * @param string $x
     * @param string $y
     * @return string
     */
    abstract public function gcd($x, $y);

    /**
     * extended euclidean calculation
     * @param string $x
     * @param string $y
     * @return array
     */
    abstract public function eGcd($x, $y);
}