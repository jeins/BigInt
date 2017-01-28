<?php

namespace ITS\RSA;

use ITS\BigInt\BigInt;

interface IRSA{

    /**
     * generate RSA keys
     * output p, q, e, d, n
     * @param $e
     * @param $size
     * @param null $p
     * @param null $q
     * @return mixed
     */
    public static function generateRSAKeys($e, $size, $p = null, $q = null);

    /**
     * get public key of RSA
     * output e, n
     * @param $key
     * @return mixed
     */
    public static function getPublicRSA($key);

    /**
     * get private key of RSA
     * output p, q, d, n
     * @param $key
     * @return mixed
     */
    public static function getSecretRSA($key);

    /**
     * encrypt plain text with public key
     * @param $publicKey
     * @param $plain
     * @return mixed
     */
    public static function encryptRSA($publicKey, $plain);

    /**
     * decrypt the cipher to plain text
     * @param $privateKey
     * @param $cipher
     * @return mixed
     */
    public static function decryptRSA($privateKey, $cipher);
}