<?php


namespace ITS\Tests\RSA;

use ITS\Prime\Prime;
use ITS\RSA\RSA;

class RSATest extends \PHPUnit_Framework_TestCase
{
    private function providerRSAKey()
    {
        return [
            ['p'=>'397', 'q'=>'569', 'f'=>'224928', 'e'=>'5', 'd'=>'134957'],
            ['p'=>'9862529', 'q'=>'1258001', 'f'=>'12407060224000', 'e'=>'3', 'd'=>'8271373482667'],
            ['p'=>'9862529', 'q'=>'1258001', 'f'=>'12407060224000', 'e'=>'65537', 'd'=>'5464732905473'],
            ['p'=>'295077413', 'q'=>'295082621', 'f'=>'87072215835779440', 'e'=>'3', 'd'=>'58048143890519627'],
            ['p'=>'295077413', 'q'=>'295082621', 'f'=>'87072215835779440', 'e'=>'65537', 'd'=>'83229915330765873'],
            ['p'=>'894539561', 'q'=>'899809241', 'f'=>'804914961633534400', 'e'=>'3', 'd'=>'536609974422356267'],
            ['p'=>'179424697', 'q'=>'179430413', 'f'=>'32194247126254752', 'e'=>'179428943', 'd'=>'8286013874856719'],
            ['p'=>'167988556341760475137', 'q'=>'3560841906445833920513', 'f'=>'598180691225077754353737922393926776389632', 'e'=>'5', 'd'=>'239272276490031101741495168957570710555853'],
            ['p'=>'7455602825647884208337395736200454918783366342657', 'q'=>'4659775785220018543264560743076778192897', 'f'=>'34741437511171958643352682099698961413263372712036566151842030383739565268100676400971776', 'e'=>'65537', 'd'=>'11262063260827444975785094392604245467823982685616016111446723766766056794189524545503233'],
            ['p'=>'59649589127497217', 'q'=>'5704689200685129054721', 'f'=>'340282366920938457758625757157511659520', 'e'=>'7', 'd'=>'194447066811964833004929004090006662583']
        ];
    }

    public function testGenerateRandomPrime()
    {
        $randomPrime = RSA::generatePrime(10);
        $round = 10;

        $this->assertTrue(Prime::isPrimeEulerWithRandomNum($randomPrime, $round));
    }

    public function testGenerateRSAKey()
    {
        foreach ($this->providerRSAKey() as $rsaKey){
            $resultGenerateRSAKey = RSA::generateRSAKeys($rsaKey['e'], 0, $rsaKey['p'], $rsaKey['q']);

            $getPublicKey = RSA::getPublicRSA($resultGenerateRSAKey);
            $getPrivateKey = RSA::getSecretRSA($resultGenerateRSAKey);

            $n = gmp_strval(gmp_mul($rsaKey['p'], $rsaKey['q']));

            $this->assertSame($getPrivateKey['p'], $rsaKey['p']);
            $this->assertSame($getPrivateKey['q'], $rsaKey['q']);
            $this->assertSame($getPrivateKey['n'], $n);
            $this->assertSame($getPrivateKey['d'], $rsaKey['d']);

            $this->assertSame($getPublicKey['e'], $rsaKey['e']);
            $this->assertSame($getPublicKey['n'], $n);
        }
    }
}