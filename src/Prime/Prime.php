<?php


namespace ITS\Prime;

use ITS\BigInt\BigInt;

class Prime implements IPrime
{

    /**
     * @param $number
     * @param $rounds
     * @return boolean
     */
    public static function isPrimeFermatWithRandomNum($number, $rounds)
    {
        if($number < 2 || bcmod($number, 2) == 0) return false;
        if((int)$number === 2) return true;

        $isPrime = [];

        for($i=0; $i<$rounds; $i++){
            $getRandomNumber = rand(2, $number-1);

            if(self::doFermatTest($number, $getRandomNumber) !== '1') {
                $isPrime[] = false;
            } else{
                $isPrime[] = true;
            }
        }

        return (in_array(false, $isPrime)) ? false : true;
    }

    /**
     * @param $number
     * @param $bases
     * @return mixed
     */
    public static function isPrimeFermatWithArrayNumbers($number, $bases)
    {
        if($number < 2 || bcmod($number, 2) == 0) return false;
        if((int)$number === 2) return true;
        if(bcmod($number, 2) == 0) return false;

        foreach ($bases as $basis){
            if(self::doFermatTest($number, $basis) !== '1') {
                return false;
            }
        }

        return true;
    }

    public static function isPrimeEulerWithRandomNum($number, $rounds)
    {
        if($number < 2 || bcmod($number, 2) == 0) return false;
        if((int)$number === 2) return true;

        $isPrime = [];

        for($i=0; $i<$rounds; $i++){
            $getRandomNumber = rand(2, $number-1);

            $res = self::doEulerTest($number, $getRandomNumber);
            if(!($res == 1 || $res == $number - 1)) {
                $isPrime[] = false;
            } else{
                $isPrime[] = true;
            }
        }

        return (in_array(false, $isPrime)) ? false : true;
    }

    public static function isPrimeEulerWithArrayNumbers($number, $bases)
    {
        if($number < 2 || bcmod($number, 2) == 0) return false;
        if((int)$number === 2) return true;

        foreach ($bases as $basis){
            $res = self::doEulerTest($number, $basis);

            if(!($res == 1 || $res == $number - 1)) {
                return false;
            }

        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public static function doFermatTest($expectedPrime, $randNumber)
    {
        $bigInt = BigInt::string2BigInt((string)$randNumber);
        $expectedPrimeToBigInt = BigInt::string2BigInt((string)$expectedPrime);

        $powMod = $bigInt->powerMod($expectedPrimeToBigInt->subWith(BigInt::string2BigInt('1'))->value, $expectedPrime);

        return $powMod->value;
    }

    /**
     * @inheritDoc
     */
    public static function doEulerTest($expectedPrime, $randNumber)
    {
        $bigInt = BigInt::string2BigInt((string)$randNumber);
        $expectedPrimeToBigInt = BigInt::string2BigInt((string)$expectedPrime);

        $tmp = $expectedPrimeToBigInt->subWith(BigInt::string2BigInt('1'))->divWith(BigInt::string2BigInt('2'));
        $powMod = $bigInt->powerMod($tmp->value, $expectedPrime);

        return $powMod->value;
    }

    /**
     * @inheritDoc
     */
    public static function doMillerRabinTest($expectedPrime, $randNumber)
    {
        $d = $expectedPrime - 1;
        $s = 0;
        while ($d % 2 == 0) {
            $d /= 2;
            $s++;
        }

        $x = bcpowmod($randNumber, $d, $expectedPrime);

        if ($x == 1 || $x == $expectedPrime-1){
            return false;
        } else{
            for ($i = 1; $i < $s-1; $i++) {
                $x = bcpowmod($randNumber, bcmul($d, bcpow(2, $i)), $expectedPrime);
                if ($x == 1)
                    return false;
                if ($x == $expectedPrime-1)
                    return true;
            }

            return true;
        }
    }
}