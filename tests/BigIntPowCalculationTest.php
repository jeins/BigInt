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

    private function providerPowModCalculation()
    {
        return [
            ['0', '1', '1'],
            ['1', '0', '1'],
            ['1', '1', '1'],
            ['0', '1', '12'],
            ['1', '0', '12'],
            ['2', '588', '57687'],
            ['588', '2', '57687'],
            ['23', '2173', '475'],
            ['2173', '23', '475'],
            ['6478', '834', '3454568456'],
            ['4838', '38543', '845696765'],
            ['38543', '4838', '845696765'],
            ['49838', '38848', '8456765'],
            ['38848', '49838', '8456765']
        ];
    }

    private function providerPowModPrimCalculation()
    {
        return [
            ['0', '1', '2'],
            ['1', '0', '2'],
            ['1', '1', '2'],
            ['0', '1', '3'],
            ['1', '0', '3'],
            ['2', '588', '449'],
            ['588', '2', '499'],
            ['2', '678', '9431'],
            ['2173', '23', '475'],
            ['678', '2', '9431'],
            ['23', '2173', '11299'],
            ['2173', '23', '11299'],
            ['6371', '839', '9099469'],
            ['839', '6371', '9099469'],
            ['41858', '39848', '11749183']
        ];
    }

    public function testPower()
    {
        foreach ($this->providerPowCalculation() as $num){
            $x = $num[0];
            $y = $num[1];

            $xBigInt = BigInt::string2BigInt($x);

            $this->assertSame(BigInt::bigInt2String($xBigInt->power($y)), gmp_strval(gmp_pow($x, $y)));
        }
    }

    public function testPowerMod()
    {
        foreach ($this->providerPowModCalculation() as $num){
            $n = $num[0];
            $e = $num[1];
            $m = $num[2];

            $bigInt = BigInt::string2BigInt($n);

            $this->assertSame(BigInt::bigInt2String($bigInt->powerMod($e, $m)), bcpowmod($n, $e, $m));
        }
    }

//    public function testPowerModPrim()
//    {
//
//    }
}
