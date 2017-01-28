<?php

namespace ITS\RSA;

use ITS\BigInt\BigInt;

interface IRSA{

    /**
     * generate RSA keys
     * output p, q, e, d, n
     * @param BigInt $e
     * @param int $size
     * @return mixed
     */
    public function generateRSAKeys($e, $size);

    /**
     * get public key of RSA
     * output e, n
     * @param $key
     * @return mixed
     */
    public function getPublicRSA($key);

    /**
     * get private key of RSA
     * output p, q, d, n
     * @param $key
     * @return mixed
     */
    public function getSecretRSA($key);

    /**
     * encrypt plain text with public key
     * @param $publicKey
     * @param $plain
     * @return mixed
     */
    public function encryptRSA($publicKey, $plain);

    /**
     * decrypt the cipher to plain text
     * @param $privateKey
     * @param $cipher
     * @return mixed
     */
    public function decryptRSA($privateKey, $cipher);
}