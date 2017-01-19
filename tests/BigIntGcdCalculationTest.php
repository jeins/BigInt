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

    private function providerEGcdCalculation()
    {
        return [
            ['12', '25'],
//            ['123', '257'],
//            ['123701', '97987886'],
//            ['9659658865765', '253254353464566'],
//            ['38684564568864386436', '25325435346475661'],
//            ['386845645688864386436', '253254353464736775661'],
//            ['373464563457356765765', '6585684354564575676587687687697657'],
//            ['3734645634573567657653245436457457456865131', '6585684354564575676587687687697657686757546464545343431'],
//            ['37346456345735676576532454364574574568651311243324325132543464656451', '843843856945931838738388543854388483737554886486859795645995964384388437532737173737735858832853853228383287327373271']
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

//    public function testEGcd()
//    {
//        foreach ($this->providerEGcdCalculation() as $num){
//            $x = $num[0];
//            $y = $num[1];
//
//            $xBingInt = BigInt::string2BigInt($x);
//
//            $bigIntResult = $xBingInt->eGcd($y);
//            $bigIntResultG = $bigIntResult[0];
//            $bigIntResultS = $bigIntResult[1];
//            $bigIntResultT = $bigIntResult[2];
//
//            $gmpResult = gmp_gcdext($x, $y);
//            $gmpResultG = gmp_strval($gmpResult['g']);
//            $gmpResultS = gmp_strval($gmpResult['s']);
//            $gmpResultT = gmp_strval($gmpResult['t']);
//
//            $this->assertSame((string)$bigIntResultG->value, $gmpResultG);
//            $this->assertSame((string)$bigIntResultS->value, $gmpResultS);
//            $this->assertSame((string)$bigIntResultT->value, $gmpResultT);
//        }
//    }
}
