<?php

namespace ITS;

use ITS\Calculation\Calculation;

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

    public static function compareWith($x, $y)
    {
        $x = BigInt::set($x);
        $y = BigInt::set($y);
        $calc = new Calculation();

        if($x instanceof BigInt && $y instanceof BigInt) return $calc->compare($x->value, $y->value);

        return - self::compareWith($y, $x);
    }

    public static function eq($x, $y)
    {
        $x = BigNumber::set($x);
        $y = BigNumber::set($y);

        return self::compareWith($x, $y) == 0;
    }

    public static function gt($x, $y){
        return self::compareWith($x, $y) > 0;
    }
    public function even($n){}
    public function bit($x, $y){}
    public function shift($x, $y){}
    public function zeroBits($n){}
    public function reduce($n, $m){}
    public function copy($x, $b){}
}