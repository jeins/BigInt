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
     * @param BigInt $e
     * @param int $size
     * @return mixed
     */
    public function generateRSAKeys($e, $size)
    {
        // TODO: Implement generateRSAKeys() method.
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getPublicRSA($key)
    {
        // TODO: Implement getPublicRSA() method.
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getSecretRSA($key)
    {
        // TODO: Implement getSecretRSA() method.
    }

    /**
     * @param $publicKey
     * @param $plain
     * @return mixed
     */
    public function encryptRSA($publicKey, $plain)
    {
        // TODO: Implement encryptRSA() method.
    }

    /**
     * @param $privateKey
     * @param $cipher
     * @return mixed
     */
    public function decryptRSA($privateKey, $cipher)
    {
        // TODO: Implement decryptRSA() method.
    }
}