<?php

namespace ITS\Tests\BigInt;


use ITS\BigInt\BigInt;

class BigIntHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testEqualsBigInt()
    {
        $x = '497323236293994552945025999384123393152510078904252194576614865391888856047008115326975';
        $y = '497323236293994552945025999384123393152510078904252194576614865391888856047008115326975';

        $xBigInt = BigInt::string2BigInt($x);
        $yBigInt = BigInt::string2BigInt($y);

        $this->assertTrue(BigInt::eq($xBigInt, $yBigInt));
    }

    public function testNotEqualsBigInt()
    {
        $x = '497323236293994552945025999384123393152510078904252194576614865391888856047008115326975';
        $y = '497323236293994552945025999384';

        $xBigInt = BigInt::string2BigInt($x);
        $yBigInt = BigInt::string2BigInt($y);

        $this->assertFalse(BigInt::eq($xBigInt, $yBigInt));
    }

    public function testXBiggerThanY()
    {
        $x = '497323236293994552945025999384123393152510078904252194576614865391888856047008115326975';
        $y = '497323236293994552945025999384';

        $xBigInt = BigInt::string2BigInt($x);
        $yBigInt = BigInt::string2BigInt($y);

        $this->assertTrue(BigInt::gt($xBigInt, $yBigInt));
    }

    public function testYSmallerThanX()
    {
        $x = '497323236293994552945025999384123393152510078904252194576614865391888856047008115326975';
        $y = '497323236293994552945025999384';

        $xBigInt = BigInt::string2BigInt($x);
        $yBigInt = BigInt::string2BigInt($y);

        $this->assertFalse(BigInt::gt($yBigInt, $xBigInt));
    }

    public function testEven()
    {
        $x = '2222222222222222222222222222222222222222222222222222222222222222222';

        $this->assertTrue(BigInt::even(BigInt::string2BigInt($x)->value));
    }

    public function testNotEven()
    {
        $x = '22222222222222222222222222222222222222222222222222222222222222222223';

        $this->assertFalse(BigInt::even(BigInt::string2BigInt($x)->value));
    }

    public function testCopy()
    {
        $x = '497323236293994552945025999384123393152510078904252194576614865391888856047008115326975';
        $y = null;

        $this->assertSame(BigInt::copy($x, $y), $x);
    }
}
