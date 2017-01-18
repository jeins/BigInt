<?php


namespace ITS\Calculation;


class Calculation extends AbstractCalculation
{
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

    /**
     * adds two numbers.
     * @param string $x
     * @param string $y
     * @return string
     */
    public function add($x, $y)
    {
        if($x === '0') return $y;

        if($y === '0') return $x;

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

    /**
     * subtracts two numbers.
     * @param string $x
     * @param string $y
     * @return string
     */
    public function sub($x, $y)
    {
        $this->init($x, $y, $xDig, $yDig, $xNeg, $yNeg, $xLen, $yLen);

        if ($xLen <= $this->maxDigitsAddDiv && $yLen <= $this->maxDigitsAddDiv) {
            return (string) ((int) $x - (int) $y);
        }

        if($xDig === $yDig) return '0';

        $compare = $this->compareUnsigned($xDig, $yDig, $xLen, $yLen);
        $invert = ($compare === -1);

        if($invert){
            $tmp = $xDig;
            $xDig = $yDig;
            $yDig = $tmp;

            $tmpLen = $xLen;
            $xLen = $yLen;
            $yLen = $tmpLen;
        }

        $size = $this->resize($xDig, $yDig, $xLen, $yLen);
        $over = 0;
        $result = '';

        for($i=$size-1; $i >= 0; $i--){
            $sum = (int) $xDig[$i] - (int) $yDig[$i] - $over;

            if($sum < 0){
                $over = 1;
                $sum += 10;
            } else {
                $over = 0;
            }

            $result .= $sum;
        }

        $result = strrev($result);
        $result = ltrim($result, '0');

        if($invert) $result = $this->negate($result);

        return $result;
    }



    /**
     * multiplies two numbers.
     * @param string $x
     * @param string $y
     * @return string
     */
    public function mul($x, $y)
    {
        if($x === '0' || $y === '0') return '0';
        if($x === '1') return $y;
        if($y === '1') return $x;
        if($x === '-1') return $this->negate($y);
        if($y === '-1') return $this->negate($x);

        $this->init($x, $y, $xDig, $yDig, $xNeg, $yNeg, $xLen, $yLen);

        if ($xLen <= $this->maxDigitsMul && $yLen <= $this->maxDigitsMul) {
            return (string) ((int) $x * (int) $y);
        }

        $result = '0';

        for($i = $xLen - 1; $i >= 0; $i--){
            $line = str_repeat('0', $xLen - 1 - $i);
            $over = 0;

            for($j = $yLen - 1; $j >= 0; $j--){
                $mul = (int) $xDig[$i] * (int) $yDig[$j] + $over;
                $digit = $mul % 10;
                $over = ($mul - $digit) / 10;
                $line .= $digit;
            }

            if($over !== 0) $line .= $over;

            $line = rtrim($line, '0');

            if($line !== '') $result = $this->add($result, strrev($line));
        }

        if($xNeg !== $yNeg) $result = $this->negate($result);

        return $result;
    }

    /**
     * division of two numbers and return quotient and remainder
     * @param string $x
     * @param string $y
     * @return array [quotient, remainder]
     */
    public function div($x, $y)
    {
        if($x === '0') return ['0', '0'];
        if($x === $y) return ['1', '0'];
        if($y === '1') return [$x, '0'];
        if($y === '-1') return [$this->negate($x), '0'];

        $this->init($x, $y, $xDig, $yDig, $xNeg, $yNeg, $xLen, $yLen);

        if ($xLen <= $this->maxDigitsAddDiv && $yLen <= $this->maxDigitsAddDiv) {
            $a = (int) $x;
            $b = (int) $y;

            $r = $a % $b;
            $q = ($a - $r) / $b;

            $q = (string) $q;
            $r = (string) $r;

            return [$q, $r];
        }

        list ($q, $r) = $this->divProcessor($x, $y, $xLen, $yLen);

        if ($xNeg !== $yNeg) {
            $q = $this->negate($q);
        }

        if ($xNeg) {
            $r = $this->negate($r);
        }

        return [$q, $r];
    }

    /**
     * division processor of two non-signed large integers.
     *
     * @param string $x
     * @param string $y
     * @param int $xLen
     * @param int $yLen
     * @return string[] quotient & remainder
     */
    private function divProcessor($x, $y, $xLen, $yLen)
    {
        $compare = $this->compareUnsigned($x, $y, $xLen, $yLen);

        if ($compare === -1) {
            return ['0', $x];
        }

        $q = '0'; // quotient
        $r = $x; // remainder
        $z = $yLen;

        for (;;) {
            $focus = substr($x, 0, $z);

            $compare = $this->compareUnsigned($focus, $y, $z, $yLen);

            if ($compare === -1) {
                if ($z === $xLen) {  // remainder < dividend
                    break;
                }

                $z++;
            }

            $zeros = str_repeat('0', $xLen - $z);

            $q = $this->add($q, '1' . $zeros);
            $x = $this->sub($x, $y . $zeros);

            $r = $x;

            if ($r === '0') { // remainder == 0
                break;
            }

            $xLen = strlen($x);

            if ($xLen < $yLen) { // remainder < dividend
                break;
            }

            $z = $yLen;
        }

        return [$q, $r];
    }

    /**
     * exponentiate a number.
     * @param string $x
     * @param int $y
     * @return string
     */
    public function power($x, $y)
    {
        if ($y === 0) return '1';
        if ($y === 1) return $x;

        $odd = $y % 2;
        $y -= $odd;

        $aa = $this->mul($x, $x);

        $result = $this->power($aa, $y / 2);

        if ($odd === 1) {
            $result = $this->mul($result, $x);
        }

        return $result;
    }

    public function powerMod($x, $y, $m)
    {
        $result = '1';

        do {
            if (!bccomp(bcmod($y, '2'), '1')) {
                $result = bcmod($this->mul($result, $x), $m);
            }
            $x = bcmod($this->power($x, '2'), $m);
            $y = bcdiv($y, '2');
        } while (bccomp($y, '0'));

        return $result;
    }

    public function powerModPrim($x, $y, $p)
    {
        if($y < $p-1){
            return $this->powerMod($x, $y, $p);
        }

        if($x < $p){
            $y = bcmod($y, ($p-1));
            return $this->powerMod($x, $y, $p);
        }

        return $this->powerMod($x, $y, $p);
    }

    public function gcd($x, $y)
    {
        if ($x === '0') return $this->absolute($y);
        if ($y === '0') return $this->absolute($x);

        return $this->gcd($y, $this->div($x, $y)[1]); //$this->div($x, $y)[1] get the remainder
    }

    public function eGcd($x, $y)
    {
        // TODO: Implement eGcd() method.
    }

    /**
     * Pads the left of one of the given numbers with zeros if necessary to make both numbers the same length.
     * @param string $x
     * @param string $y
     * @param int $xLen
     * @param int $yLen
     * @return int
     */
    private function resize(&$x, &$y, $xLen, $yLen)
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
}