<?php


namespace ITS\Tests\BigInt;


use ITS\BigInt\BigInt;

class BigIntRandomNumberTest extends \PHPUnit_Framework_TestCase
{
    public function testRandomNumber()
    {
        $sizeStr = [10, 1000, 100000, 1000000, 10000000];

        foreach ($sizeStr as $size){
            $strRandomNumber = BigInt::bigInt2String(BigInt::getRandom($size));

            $this->assertSame(strlen($strRandomNumber), $size);
        }
    }

    public function testRandomOddNumber()
    {
        $sizeStr = [10, 1000, 100000, 1000000, 10000000];

        foreach ($sizeStr as $size){
            $strRandomNumber = BigInt::bigInt2String(BigInt::getRandomOdd($size));
            $this->assertTrue(bcmod($strRandomNumber, 2) != 0);
        }
    }
}
