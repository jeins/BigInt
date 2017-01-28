<?php

namespace ITS\RSA;

use ITS\BigInt\BigInt;
use ITS\Prime\Prime;

class RSA implements IRSA
{
    /**
     * generate prime number with specific size
     * @param $size
     * @return string
     */
    public static function generatePrime($size)
    {
        $randomNumber = BigInt::getRandomOdd($size);

        while(!Prime::isPrimeEulerWithRandomNum($randomNumber->value, '10')){
            $randomNumber = $randomNumber->addWith(BigInt::string2BigInt('1'));
        }

        return $randomNumber->value;
    }

    /**
     * @inheritDoc
     */
    public static function generateRSAKeys($e, $size, $p = null, $q = null)
    {
        $p = ($p == null) ? self::generatePrime($size) : $p;
        do{
            $q = ($q == null) ? self::generatePrime($size) : $q;
        }while(BigInt::eq($p, $q));

        $bigIntOfP = BigInt::string2BigInt((string)$p);
        $bigIntOfQ = BigInt::string2BigInt((string)$q);

        // calc phi
        $pMinusOne = $bigIntOfP->subWith(BigInt::string2BigInt('1'));
        $qMinusOne = $bigIntOfQ->subWith(BigInt::string2BigInt('1'));
        $phi = $pMinusOne->mulWith($qMinusOne->value)->value;

        // calc n
        $n = $bigIntOfP->mulWith($bigIntOfQ->value)->value;

        $d = gmp_strval(gmp_invert($e, $phi));

        return ['p'=>$p, 'q'=>$q, 'n'=>$n, 'e'=>$e, 'd'=>$d];
    }

    /**
     * @inheritDoc
     */
    public static function getPublicRSA($key)
    {
        return [
            'e' => $key['e'],
            'n' => $key['n']
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getSecretRSA($key)
    {
        return [
            'p' => $key['p'],
            'q' => $key['q'],
            'd' => $key['d'],
            'n' => $key['n']
        ];
    }

    /**
     * @inheritDoc
     */
    public static function encryptRSA($publicKey, $plain)
    {
        $bigIntOfPlain = BigInt::string2BigInt((string)$plain);

        return $bigIntOfPlain->powerMod($publicKey['e'], $publicKey['n'])->value;
    }

    /**
     * @inheritDoc
     */
    public static function decryptRSA($privateKey, $cipher)
    {
        $bigIntOfCipher = BigInt::string2BigInt((string)$cipher);

        return $bigIntOfCipher->powerMod($privateKey['d'], $privateKey['n'])->value;
    }
}