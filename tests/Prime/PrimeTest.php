<?php


namespace ITS\Tests\Prime;


use ITS\Prime\Prime;


class PrimeTest extends \PHPUnit_Framework_TestCase
{
    private function providerFermatPseudoPrime()
    {
        return [
            [['64'], '105'],
            [['40'], '123'],
            [['121'], '183'],
            [['146'], '203'],
            [['86'], '377'],
            [['76'], '385'],
            [['546'], '2735']
        ];
    }

    private function providerEulerPseudoPrime()
    {
        return [
            [['128'], '341'],
            [['1172'], '1681'],
            [['315'], '2449'],
            [['1842'], '4997'],
            [['2169'], '4961']
        ];
    }

    public function testPrimeWithFermat()
    {
        $expectedPrime = 199;
        $round = 30;
        $this->assertTrue(Prime::isPrimeFermatWithRandomNum($expectedPrime, $round));
    }


    public function testNotPrimeWithFermat()
    {
        $notPrime = 2735;
        $round = 30;
        $this->assertFalse(Prime::isPrimeFermatWithRandomNum($notPrime, $round));
    }

    public function testPrimeWithEuler()
    {
        $expectedPrime = 173;
        $round = 50;
        $this->assertTrue(Prime::isPrimeEulerWithRandomNum($expectedPrime, $round));
    }

    public function testNotPrimeWithEuler()
    {
        $notPrime = 4371;
        $round = 50;
        $this->assertFalse(Prime::isPrimeEulerWithRandomNum($notPrime, $round));
    }

    public function testPrimeWithMR()
    {
        $expectedPrime = 193;
        $round = 50;
        $this->assertTrue(Prime::isPrimeMRWithRandomNum($expectedPrime, $round));
    }

    public function testNotPrimeWithMR()
    {
        $notPrime = 4371;
        $round = 40;
        $this->assertFalse(Prime::isPrimeMRWithRandomNum($notPrime, $round));
    }

    public function testPseudoPrimeFromBasesWithFermat()
    {
        foreach ($this->providerFermatPseudoPrime() as $num){
            $this->assertTrue(Prime::isPrimeFermatWithBases($num[1], $num[0]));
        }
    }

    public function testPseudoPrimeFromBasesWithEuler()
    {
        foreach ($this->providerEulerPseudoPrime() as $prov){
            $this->assertTrue(Prime::isPrimeEulerWithBases($prov[1], $prov[0]));
        }
    }
}
