<?php

namespace ITS\Tests;


use ITS\BigInt;

class BigIntGcdCalculationTest extends \PHPUnit_Framework_TestCase
{

    private function providerGcdCalculation()
    {
        return [
            ['75', '20'],
            ['123', '15'],
            ['7456', '958'],
            ['76979890', '945430'],
            ['11103345185975', '2270275'],
            ['730367087', '166688028430575'],
            ['54015938673278400', '196369218978279110400'],
            ['245096536056936046682799600', '543506203945812017181853335600'],
            ['166583189154164405471255668927050', '237943671504660342319369169038140'],
            ['-75', '20'],
            ['75', '-20']
        ];
    }

    public function testGcd()
    {
        foreach ($this->providerGcdCalculation() as $num){
            $x = $num[0];
            $y = $num[1];

            $xBingInt = BigInt::string2BigInt($x);

            $this->assertSame(BigInt::bigInt2String($xBingInt->gcd($y)), gmp_strval(gmp_gcd($x, $y)));
        }
    }
}
