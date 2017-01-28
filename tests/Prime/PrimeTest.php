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

    public function testPrimeWithIsPrimeFermat()
    {
        $this->assertTrue(Prime::isPrimeFermatWithRandomNum(13, 6));
    }


    public function testNotPrimeWithIsPrimeFermat()
    {
        $this->assertFalse(Prime::isPrimeFermatWithRandomNum(2735, 10));
    }

    public function testPrimeWithIsPrimeEuler()
    {
        $this->assertTrue(Prime::isPrimeEulerWithRandomNum(13, 10));
    }

    public function testNotPrimeWithIsPrimeEuler()
    {
        $this->assertFalse(Prime::isPrimeEulerWithRandomNum(4371, 10));
    }

    public function testPrimeFromBasesWithIsPrimeFermat()
    {
        foreach ($this->providerFermatPseudoPrime() as $num){
            var_dump($num[1]);
            $this->assertTrue(Prime::isPrimeFermatWithArrayNumbers($num[1], $num[0]));
        }
    }

    public function testPrimeFromBasesWithIsPrimeEuler()
    {
        foreach ($this->providerEulerPseudoPrime() as $prov){
            $this->assertTrue(Prime::isPrimeEulerWithArrayNumbers($prov[1], $prov[0]));
        }
    }
}
