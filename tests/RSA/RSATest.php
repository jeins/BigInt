<?php


namespace ITS\Tests\RSA;

use ITS\Prime\Prime;
use ITS\RSA\RSA;

class RSATest extends \PHPUnit_Framework_TestCase
{
    public function testGenrateRandomPrime()
    {
        $randomPrime = RSA::generatePrime(10);
        $round = 10;
var_dump($randomPrime);
        $this->assertTrue(Prime::isPrimeEulerWithRandomNum($randomPrime, $round));
    }
}