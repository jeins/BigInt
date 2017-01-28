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
            [['137'], '244'],
            [['3'], '286'],
            [['144'], '319'],
            [['213'], '341'],
            [['86'], '377'],
            [['76'], '385'],
            [['233'], '406'],
            [['177'], '2572'],
            [['753'], '2632'],
            [['546'], '2735']
        ];
    }

    public function testPrimeWithIsPrimeFermat()
    {
        $this->assertTrue(Prime::isPrimeFermatWithRandomNum(13, 10));
    }


    public function testNotPrimeWithIsPrimeFermat()
    {
        $this->assertFalse(Prime::isPrimeFermatWithRandomNum(10, 3));
    }

//    public function testPrimeFromBasesWithIsPrimeFermat()
//    {
//        foreach ($this->providerFermatPseudoPrime() as $num){
//            $this->assertTrue(Prime::isPrimeFermatWithArrayNumbers($num[1], $num[0]));
//        }
//    }
}
