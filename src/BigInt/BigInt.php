<?php

namespace ITS\BigInt;

use ITS\BigInt\Calculation\Calculation;

class BigInt extends BigNumber
{
    /**
     * @var string
     */
    public $value;

    /**
     * @var Calculation
     */
    private $cal;

    public function __construct($value)
    {
        $this->value = $value;
        $this->cal = new Calculation();
    }

    /**
     * addition the bigint with another bigint
     * @param $n
     * @return $this|BigInt
     */
    public function addWith($n)
    {
        $n = BigInt::set($n);

        if($this->value === '0') return $this;

        $result = $this->cal->add($this->value, $n->value);

        return new BigInt($result);
    }

    /**
     * subtracts the bigint with another bigint
     * @param $n
     * @return $this|BigInt
     */
    public function subWith($n)
    {
        $n = BigInt::set($n);

        if($this->value === '0') return $this;

        $result = $this->cal->sub($this->value, $n->value);

        return new BigInt($result);
    }

    /**
     * multiplies the bigint with another bigint
     * @param $n
     * @return $this|BigInt
     */
    public function mulWith($n)
    {
        $n = BigInt::set($n);

        if($n->value === '1') return $this;

        $result = $this->cal->mul($this->value, $n->value);

        return new BigInt($result);
    }

    /**
     * division the bigint with another bigint
     * @param $n
     * @return $this|BigInt
     * @throws \Exception
     */
    public function divWith($n)
    {
        $n = BigInt::set($n);

        if($n->value === '1') return $this;
        if($n->value === '0') throw new \Exception("division by zero not allowed!");

        $result = $this->cal->div($this->value, $n->value)[0]; // get quotient

        return new BigInt($result);
    }

    /**
     * exponentiation the big int with exponent
     * @param $exponent
     * @return BigInt
     */
    public function power($exponent)
    {
        return new BigInt($this->cal->power($this->value, (int)$exponent));
    }

    /**
     * exponentiation the big int with modulo
     * @param $e
     * @param $m
     * @return BigInt
     */
    public function powerMod($e, $m)
    {
        return new BigInt($this->cal->powerMod($this->value, $e, $m));
    }

    /**
     * exponentiation module the big int with a prime
     * @param $e
     * @param $p
     * @return BigInt
     */
    public function powerModPrim($e, $p)
    {
        return new BigInt($this->cal->powerModPrim($this->value, (int)$e, $p));
    }

    /**
     * euclidean calculation
     * @param $n
     * @return $this|BigInt|string
     */
    public function gcd($n)
    {
        $n = BigInt::set($n);

        if ($n->value === '0' && $this->value[0] !== '-') return $this;

        if ($this->value === '0' && $n->value[0] !== '-') return $n;

        $result = $this->cal->gcd($this->value, $n->value);

        return new BigInt($result);
    }

    /**
     * extended euclidean calculation
     * @param $n
     * @return array|BigInt
     */
    public function eGcd($n)
    {
        $n = BigInt::set($n);

        if ($n->value === '0' && $this->value[0] !== '-') return $this;

        if ($this->value === '0' && $n->value[0] !== '-') return $n;

        $result = $this->cal->eGcd($this->value, $n->value);

        return [new BigInt($result[0]), new BigInt($result[1]), new BigInt($result[2])];
    }

    /**
     * convert to big integer
     * @return $this
     */
    public function toBigInteger()
    {
        return $this;
    }

    /**
     * get the string value
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * convert string to big integer
     * @param $n
     * @return $this
     */
    public static function string2BigInt($n){
        return BigInt::set($n)->toBigInteger();
    }

    /**
     * convert big integer to string
     * @param $n
     * @return string
     */
    public static function bigInt2String($n){
        return (string)BigInt::set($n);
    }

    /**
     * convert int to bit integer
     * @param $n
     * @return $this
     */
    public static function int2BigInt($n){
        return BigInt::set((int)$n)->toBigInteger();
    }

    /**
     * generate random number from size
     * @param $size
     * @return BigInt
     */
    public static function getRandom($size){
        $result = '';

        for($i = 0; $i < $size; $i++) {
            $result .= mt_rand(0, 9);
        }

        return new BigInt($result);
    }

    /**
     * generate random odd number from size
     * @param $size
     * @return BigInt
     */
    public static function getRandomOdd($size){
        $randomNum = self::getRandom($size);

        while(bcmod($randomNum, 2) == 0){
            $randomNum = $randomNum->addWith(BigInt::set('1'));
        }

        return $randomNum;
    }
}