<?php

namespace ITS\Tests;


use ITS\BigInt;

class BigIntPowCalculationTest extends \PHPUnit_Framework_TestCase
{
    private function providerPowCalculation()
    {
        return [
            ['0', '0'],
            ['0', '1'],
            ['1', '0'],
            ['8213483249239195943824586856824583458432868382184821358', '1'],
//            ['1', '8213483249239195943824586856824583458432868382184821358'],
            ['2', '588'],
            ['588', '2'],
            ['2173', '23'],
            ['23', '2173'],
            ['6478', '834'],
            ['834', '6478'],
            ['4838', '38543'],
            ['38543', '4838']
        ];
    }

    private function bigInt()
    {
        return new BigInt();
    }

    public function testPower()
    {
        foreach ($this->providerPowCalculation() as $num){
            $x = $num[0];
            $y = $num[1];

            $this->assertSame($this->bigInt()->power($x, $y), gmp_strval(gmp_pow($x, $y)));
        }
    }

}
