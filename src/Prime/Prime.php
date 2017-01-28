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
        if($number < 2) return false;
        if((int)$number === 2) return true;
        if(bcmod($number, 2) == 0) return false;

        for($i=0; $i<$rounds; $i++){
            $getRandomNumber = rand(2, $number-1);

            if(self::doFermatPseudoPrime($number, $getRandomNumber) !== '1') {
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
    public static function isPrimeFermatWithArrayNumbers($number, $bases)
    {
        if($number < 2) return false;
        if((int)$number === 2) return true;
        if(bcmod($number, 2) == 0) return false;

        for($i=0; $i<count($bases); $i++){
            if(self::doFermatPseudoPrime($number, $bases[$i]) !== '1') {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public static function doFermatPseudoPrime($expectedPrime, $randNumber)
    {
        $bigInt = BigInt::string2BigInt((string)$randNumber);
        $powMod = $bigInt->powerMod($expectedPrime-1, $expectedPrime);

        return $powMod->value;
    }

    /**
     * @inheritDoc
     */
    public static function doEulerPseudoPrime($expectedPrime, $randNumber)
    {
        // TODO: Implement doEulerPseudoPrime() method.
    }

    /**
     * @inheritDoc
     */
    public static function doMrPseudoPrime($expectedPrime, $randNumber)
    {
        // TODO: Implement doMrPseudoPrime() method.
    }
}