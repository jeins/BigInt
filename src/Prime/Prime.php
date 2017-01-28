<?php


namespace ITS\Prime;

use ITS\BigInt\BigInt;

class Prime implements IPrime
{

    /**
     * check is prime with fermat test, generate new each rounds
     * @param $number
     * @param $rounds
     * @return boolean
     */
    public static function isPrimeFermatWithRandomNum($number, $rounds)
    {
        if((int)$number === 2) return true;
        if($number < 2 || bcmod($number, 2) == 0) return false;

        for($i=0; $i<$rounds; $i++){
            if(self::doFermatTest($number, self::generateRandomNumber($number)) !== '1') {
                return false;
            }
        }

        return true;
    }

    /**
     * check is prime with fermat test from bases numbers
     * @param $number
     * @param $bases
     * @return mixed
     */
    public static function isPrimeFermatWithBases($number, $bases)
    {
        if((int)$number === 2) return true;
        if($number < 2 || bcmod($number, 2) == 0) return false;

        foreach ($bases as $basis){
            if(self::doFermatTest($number, $basis) !== '1') {
                return false;
            }
        }

        return true;
    }

    /**
     * check is prime with euler test, generate new each rounds
     * @param $number
     * @param $rounds
     * @return bool
     */
    public static function isPrimeEulerWithRandomNum($number, $rounds)
    {
        if((int)$number === 2) return true;
        if($number < 2 || bcmod($number, 2) == 0) return false;

        for($i=0; $i<$rounds; $i++){
            $res = self::doEulerTest($number, self::generateRandomNumber($number));

            if(!($res == 1 || $res == $number - 1)) {
                return false;
            }
        }

        return true;
    }

    /**
     * check is prime with euler test from bases numbers
     * @param $number
     * @param $bases
     * @return bool
     */
    public static function isPrimeEulerWithBases($number, $bases)
    {
        if((int)$number === 2) return true;
        if($number < 2 || bcmod($number, 2) == 0) return false;

        foreach ($bases as $basis){
            $res = self::doEulerTest($number, $basis);

            if(!($res == 1 || $res == $number - 1)) {
                return false;
            }

        }
        return true;
    }

    /**
     * check is prime with miller rabin test, generate new each rounds
     * @param $number
     * @param $rounds
     * @return bool
     */
    public static function isPrimeMRWithRandomNum($number, $rounds)
    {
        if((int)$number === 2) return true;
        if($number < 2 || bcmod($number, 2) == 0) return false;

        $d = $number - 1;
        $s = 0;
        while ($d % 2 == 0) {
            $d /= 2;
            $s++;
        }

        for ($i = 0; $i < $rounds; $i++) {
            if(!self::doMillerRabinTest($number, self::generateRandomNumber($number), $d, $s)){
                return false;
            }
        }
        return true;
    }

    /**
     * check is prime with miller rabin test from bases numbers
     * @param $number
     * @param $bases
     * @return bool
     */
    public static function isPrimeMRWithBases($number, $bases)
    {
        if((int)$number === 2) return true;
        if($number < 2 || bcmod($number, 2) == 0) return false;

        $d = $number - 1;
        $s = 0;
        while ($d % 2 == 0) {
            $d /= 2;
            $s++;
        }

        foreach ($bases as $basis){
            if(!self::doMillerRabinTest($number, $basis, $d, $s)){
                return false;
            }
        }

        return true;
    }

    /**
     * check is prime with trial division from bases numbers
     * @param $number
     * @param $bases
     * @return bool
     */
    public static function isPrimeDiv($number, $bases)
    {
        if((int)$number === 2) return true;
        if($number < 2 || bcmod($number, 2) == 0) return false;

        $bigInt = BigInt::string2BigInt((string)$number);

        foreach ($bases as $basis){
            if(bcmod($bigInt->value, $basis) === '0'){
                return false;
            }
        }

        return true;
    }

    private static function generateRandomNumber($max)
    {
        if(BigInt::gt(BigInt::string2BigInt((string)$max), BigInt::string2BigInt((string)PHP_INT_MAX))){
            return rand(2, PHP_INT_MAX);
        } else{
            return rand(2, $max-1);
        }
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
    public static function doMillerRabinTest($expectedPrime, $randNumber, $d, $s)
    {
        $bigInt = BigInt::string2BigInt((string)$randNumber);
        $expectedPrimeToBigInt = BigInt::string2BigInt((string)$expectedPrime);
        $x = $bigInt->powerMod($d, $expectedPrime);

        if (BigInt::eq($x, BigInt::string2BigInt('1')) || BigInt::eq($x, $expectedPrimeToBigInt->subWith(BigInt::string2BigInt('1')))){
            return true;
        }

        for ($i = 1; $i < $s; $i++) {
            $tmpPower = BigInt::string2BigInt('2')->power($i);
            $tmpMul = BigInt::string2BigInt((string)$d)->mulWith($tmpPower);
            $x = $bigInt->powerMod($tmpMul->value, $expectedPrime);

            if (BigInt::eq($x, BigInt::string2BigInt('1')))
                return false;
            if (BigInt::eq($x, $expectedPrimeToBigInt->subWith(BigInt::string2BigInt('1'))))
                return true;
        }

        return false;
    }
}