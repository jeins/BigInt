<?php


namespace ITS\Tests\Prime;


use ITS\Prime\Prime;


class PrimeTest extends \PHPUnit_Framework_TestCase
{
    private function providerPrimeWithBases()
    {
        return [
            ['11', ['2', '3', '5', '6', '7', '8', '9']],
            ['29', ['2', '3', '5', '6', '7', '8', '9', '11']],
            ['47', ['2', '3', '5', '6', '7', '8', '9', '11']],
            ['104729', ['2', '3', '5', '6', '7', '8', '9', '11']],
            ['7607', ['2', '3', '5', '6', '7', '8', '9', '11']],
            ['32416187563', ['2', '3', '5', '6', '7', '8', '9', '11']],
            ['32416190071', ['2', '3', '5', '6', '7', '8', '9', '11']]
        ];
    }

    private function providerNotPrime()
    {
        return [
            '1',
            '48',
            '4324213413251351',
            '457568756845876866786',
            '7665795679597579578956967957',
            '21346587698797674564778007867511111',
            '32498435834865326945234875183518437534758431',
            '45065795679459567865734568458668435765995697569421',
            '30024369469850064594387327432754385943969493248284238828538521'
        ];
    }

    private function providerPrime()
    {
        return [
            '2',
            '7607',
            '104729',
            '179422921',
            '32416187563',
            '32416190071'
        ];
    }

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
        $round = 30;
        foreach ($this->providerPrime() as $expectedPrime){
            $this->assertTrue(Prime::isPrimeFermatWithRandomNum($expectedPrime, $round));
        }
    }

    public function testNotPrimeWithFermat()
    {
        $round = 30;
        foreach ($this->providerNotPrime() as $notPrime) {
            $this->assertFalse(Prime::isPrimeFermatWithRandomNum($notPrime, $round));
        }
    }

    public function testPrimeWithEuler()
    {
        $round = 50;
        foreach ($this->providerPrime() as $expectedPrime) {
            $this->assertTrue(Prime::isPrimeEulerWithRandomNum($expectedPrime, $round));
        }
    }

    public function testNotPrimeWithEuler()
    {
        $round = 50;
        foreach ($this->providerNotPrime() as $notPrime) {
            $this->assertFalse(Prime::isPrimeEulerWithRandomNum($notPrime, $round));
        }
    }

    public function testPrimeWithMR()
    {
        $round = 50;
        foreach ($this->providerPrime() as $expectedPrime) {
            $this->assertTrue(Prime::isPrimeMRWithRandomNum($expectedPrime, $round));
        }
    }

    public function testNotPrimeWithMR()
    {
        $round = 40;
        foreach ($this->providerNotPrime() as $notPrime) {
            var_dump($notPrime);
            $this->assertFalse(Prime::isPrimeMRWithRandomNum($notPrime, $round));
        }
    }

    public function testPrimeBasesWithDiv()
    {
        foreach ($this->providerPrimeWithBases() as $primeAndBases) {
            $this->assertTrue(Prime::isPrimeDiv($primeAndBases[0], $primeAndBases[1]));
        }
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
