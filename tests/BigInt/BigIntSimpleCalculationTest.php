<?php

namespace ITS\Tests\BigInt;


use ITS\BigInt\BigInt;

class BigIntSimpleCalculationTest extends \PHPUnit_Framework_TestCase
{
    private function providerSimpleCalculation()
    {
        return [
            ['0', '0'],
            ['1', '2'],
            ['3561599', '3430399'],
            ['11907858797062763600287', '609258644980293364'],
            ['275037643193238187969754635193967098168234', '2789096463851958435408110961618870154822'],
            ['78047574151725182769714241091983435073053370965', '6081438698999606240186790021334933066970638428563610408662925699467423912567624'],
            ['1461501636990620551361974531748726005748293697535', '497323236293994552945025999384123393152510078904252194576614865391888856047008115326975'],
            ['497323236293994552945025999384123393152510078904252194576614865391888856047008115326975', '1461501636990620551361974531748726005748293697535'],
            ['1461501636990620551361974531748726005748293697535', '497323236293994552945025999384123393152510078904252194576614865391888856047008115326975'],
            ['14912223718264696338397856927216645003797842400010184754757240303931468158450472964700379410986934684302727999568876470644700283834353922266629081467130884678', '6291236858798355625002240310849051763302244841609637222019848440367474974319646025221986149943002309351421662310425123115121755038535'],
            ['225461820030056738863111393842522918646434913785508706785223950926908750687391732247955346997611273062097910735906920001391888212823475570974758772091099074195005291818882084891523756343366089648730273588212737213447787531009284731961359', '1161773002875530970475777318025858646972144071496504896369373542143925303581117880759012959257904240775262220379722624450259881493669369582103579798349025470539165815324808002121323272794820292319']
        ];
    }

    public function testAdd()
    {
        foreach ($this->providerSimpleCalculation() as $num){
            $x = $num[0];
            $y = $num[1];

            $xBigInt = BigInt::string2BigInt($x);

            $this->assertSame(BigInt::bigInt2String($xBigInt->addWith(BigInt::string2BigInt($y))), gmp_strval(gmp_add($x, $y)));
        }
    }

    public function testSub()
    {
       foreach ($this->providerSimpleCalculation() as $num){
            $x = $num[0];
            $y = $num[1];

           $xBigInt = BigInt::string2BigInt($x);

            $this->assertSame(BigInt::bigInt2String($xBigInt->subWith(BigInt::string2BigInt($y))), gmp_strval(gmp_sub($x, $y)));
        }
    }

    public function testMul()
    {
        foreach ($this->providerSimpleCalculation() as $num){
            $x = $num[0];
            $y = $num[1];

            $xBigInt = BigInt::string2BigInt($x);

            $this->assertSame(BigInt::bigInt2String($xBigInt->mulWith(BigInt::string2BigInt($y))), gmp_strval(gmp_mul($x, $y)));
        }
    }

    public function testDiv()
    {
        foreach ($this->providerSimpleCalculation() as $num){
            $x = $num[0];
            $y = $num[1];

            $xBigInt = BigInt::string2BigInt($x);

            if($y !== '0'){
                $this->assertSame(BigInt::bigInt2String($xBigInt->divWith(BigInt::string2BigInt($y))), gmp_strval(gmp_div($x, $y)));
            }
        }
    }
}
