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

        for($i=0; $i<$rounds; $i++){
            $getRandomNumber = rand(2, $number-1);

            if(self::doFermatTest($number, $getRandomNumber) !== '1') {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $number
     * @param $bases
     * @return mixed
     */
    public static function isPrimeFermatWithBases($number, $bases)
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

        for($i=0; $i<$rounds; $i++){
            $getRandomNumber = rand(2, $number-1);

            $res = self::doEulerTest($number, $getRandomNumber);
            if(!($res == 1 || $res == $number - 1)) {
                return false;
            }
        }

        return true;
    }

    public static function isPrimeEulerWithBases($number, $bases)
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

    public static function isPrimeMRWithRandomNum($number, $rounds)
    {
        if($number < 2 || bcmod($number, 2) == 0) return false;
        if((int)$number === 2) return true;

        $d = $number - 1;
        $s = 0;
        while ($d % 2 == 0) {
            $d /= 2;
            $s++;
        }

        for ($i = 0; $i < $rounds; $i++) {
            $getRandomNumber = rand(2, $number-1);

            if(!self::doMillerRabinTest($number, $getRandomNumber, $d, $s)){
                return false;
            }
        }
        return true;
    }

    public static function isPrimeMRWithBases($number, $bases)
    {
        if($number < 2 || bcmod($number, 2) == 0) return false;
        if((int)$number === 2) return true;

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