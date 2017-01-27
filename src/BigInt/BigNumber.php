<?php

namespace ITS\BigInt;

use ITS\BigInt\Calculation\Calculation;

class BigNumber
{
    /**
     * The regular expression used to parse integer, decimal and rational numbers.
     * @var string
     */
    private static $regexp =
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
     * added value to be a big int / big number
     * @param $value
     * @return BigInt|string
     * @throws \Exception
     */
    public static function set($value)
    {
        if($value instanceof BigNumber) {
            return $value;
        }

        if (is_int($value)) {
            return (string) $value;
        }

        $value = (string) $value;

        if (preg_match(self::$regexp, $value, $matches) !== 1) {
            throw new \Exception('The given value does not represent a valid number.');
        }

        return new BigInt($value);
    }

    /**
     * compare two big int
     * @param $x
     * @param $y
     * @return int
     */
    public static function compareWith($x, $y)
    {
        $x = BigInt::set($x);
        $y = BigInt::set($y);
        $calc = new Calculation();

        if($x instanceof BigInt && $y instanceof BigInt) return $calc->compare($x->value, $y->value);

        return - self::compareWith($y, $x);
    }

    /**
     * is the big equals
     * @param $x
     * @param $y
     * @return bool
     */
    public static function eq($x, $y)
    {
        $x = BigNumber::set($x);
        $y = BigNumber::set($y);

        return self::compareWith($x, $y) == 0;
    }

    /**
     * greater than
     * @param $x
     * @param $y
     * @return bool
     */
    public static function gt($x, $y){
        return self::compareWith($x, $y) > 0;
    }

    /**
     * is n even
     * @param $n
     * @return bool
     */
    public static function even($n){
        if(gmp_strval(gmp_mod($n, 2)) === '0'){
            return true;
        }

        return false;
    }

    /**
     * @param $x
     * @param $y
     */
    public function bit($x, $y){}

    /**
     * @param $x
     * @param $y
     * @return int
     */
    public static function shift($x, $y){
        if(self::gt($y, BigInt::int2BigInt(0) || self::eq($y, BigInt::int2BigInt(0)))){
            $x = $y >> 2;
        }

        return $x;
    }

    /**
     * @param $n
     */
    public function zeroBits($n){}

    /**
     * @param $n
     * @param $m
     */
    public function reduce($n, $m){}

    /**
     * copy the value of x to b, if b is null
     * @param $x
     * @param $b
     * @return mixed
     */
    public static function copy($x, $b){
        if($b === null || self::eq($b, BigInt::int2BigInt(0))){
            $b = &$x;
        }

        return $b;
    }
}