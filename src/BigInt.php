<?php

namespace ITS;

use ITS\Calculation\Calculation;

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

    public function addWith($n)
    {
        $n = BigInt::set($n);

        if($this->value === '0') return $this;

        $result = $this->cal->add($this->value, $n->value);

        return new BigInt($result);
    }

    public function subWith($n)
    {
        $n = BigInt::set($n);

        if($this->value === '0') return $this;

        $result = $this->cal->sub($this->value, $n->value);

        return new BigInt($result);
    }

    public function mulWith($n)
    {
        $n = BigInt::set($n);

        if($n->value === '1') return $this;

        $result = $this->cal->mul($this->value, $n->value);

        return new BigInt($result);
    }

    public function divWith($n)
    {
        $n = BigInt::set($n);

        if($n->value === '1') return $this;
        if($n->value === '0') throw new \Exception("division by zero not allowed!");

        $result = $this->cal->div($this->value, $n->value)[0]; // get quotient

        return new BigInt($result);
    }

    public function power($exponent)
    {
        return new BigInt($this->cal->power($this->value, (int)$exponent));
    }

    public function powerMod($e, $m)
    {
        return new BigInt($this->cal->powerMod($this->value, (int)$e, $m));
    }

    public function powerModPrim($e, $p)
    {
        return new BigInt($this->cal->powerModPrim($this->value, (int)$e, $p));
    }

    public function gcd($n)
    {
        $n = BigInt::set($n);

        if ($n->value === '0' && $this->value[0] !== '-') return $this;

        if ($this->value === '0' && $n->value[0] !== '-') return $n;

        $result = $this->cal->gcd($this->value, $n->value);

        return new BigInt($result);
    }

    public function toBigInteger()
    {
        return $this;
    }

    public function __toString()
    {
        return $this->value;
    }

    public static function string2BigInt($n){
        return BigInt::set($n)->toBigInteger();
    }
    public static function bigInt2String($n){
        return (string)BigInt::set($n);
    }
    public static function int2BigInt($n){
        return BigInt::set($n)->toBigInteger();
    }
}