<?php

namespace ITS;

class BigNumber
{
    /**
     * The regular expression used to parse integer, decimal and rational numbers.
     * @var string
     */
    private $regexp =
        '/^' .
        '(?<integral>[\-\+]?[0-9]+)' .
        '(?:' .
        '(?:' .
        '(?:\.(?<fractional>[0-9]+))?' .
        '(?:[eE](?<exponent>[\-\+]?[0-9]+))?' .
        ')' . '|' . '(?:' .
        '(?:\/(?<denominator>[0-9]+))?' .
        ')' .
        ')?' .
        '$/';

    /**
     * The max number of digits the platform can natively add, subtract or divide without overflow.
     * @var int
     */
    public $maxDigitsAddDiv = 0;

    /**
     * The max number of digits the platform can natively multiply without overflow.
     * @var int
     */
    public $maxDigitsMul = 0;

    public function __construct()
    {
        switch (PHP_INT_SIZE) {
            case 4:
                $this->maxDigitsAddDiv = 9;
                $this->maxDigitsMul = 4;
                break;
            case 8:
                $this->maxDigitsAddDiv = 18;
                $this->maxDigitsMul = 9;
                break;
        }
    }

    public function set($value)
    {
        if($value instanceof BigNumber) {
            return $value;
        }

        if (is_int($value)) {
            return (string) $value;
        }

        $value = (string) $value;

        if (preg_match($this->regexp, $value, $matches) !== 1) {
            throw new \Exception('The given value does not represent a valid number.');
        }
    }

    public function init($x, $y, &$xDig, &$yDig, &$xNeg, &$yNeg, &$xLen, &$yLen)
    {
        $xNeg = ($x[0] === '-');
        $yNeg = ($y[0] === '-');

        $xDig = $xNeg ? substr($x, 1) : $x;
        $yDig = $yNeg ? substr($y, 1) : $y;

        $xLen = strlen($xDig);
        $yLen = strlen($yDig);
    }

    /**
     * Pads the left of one of the given numbers with zeros if necessary to make both numbers the same length.
     * @param string $x
     * @param string $y
     * @param int $xLen
     * @param int $yLen
     * @return int
     */
    public function resize(&$x, &$y, $xLen, $yLen)
    {
        $biggerLength = $xLen > $yLen ? $xLen : $yLen;

        if ($xLen < $biggerLength) {
            $x = str_repeat('0', $biggerLength - $xLen) . $x;
        }
        if ($yLen < $biggerLength) {
            $y = str_repeat('0', $biggerLength - $yLen) . $y;
        }

        return $biggerLength;
    }

    /**
     *  comparing two non-signed large numbers.
     * @param string $x
     * @param string $y
     * @param int $xLen
     * @param int $yLen
     * @return int [-1, 0, 1]
     */
    public function compare($x, $y, $xLen, $yLen)
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
}