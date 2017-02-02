<?php

namespace ITS\BBS;

use ITS\BigInt\BigInt;
use ITS\Prime\Prime;

class BBS
{
    /**
     * @var BigInt
     */
    private $start;

    /**
     * @var int
     */
    private $size;

    public function __construct(BigInt $start, int $size = 10)
    {
        $this->start = $start;
        $this->size = $size;
    }

    public function randomBBS()
    {

    }

    private function getN()
    {
        $p = $this->getRandomPrime($this->start);
        $q = $this->getRandomPrime($p);

        $n = BigInt::string2BigInt($p)->mulWith(BigInt::string2BigInt($q));

        return $n->value;
    }

    private function getRandomPrime($startNum)
    {
        $prime = gmp_nextprime($startNum);

        while(!Prime::isPrimeEulerWithRandomNum($prime, '10') || !BigInt::eq(bcmod($prime, '4'), '3')){
            $prime = gmp_nextprime($startNum);
        }

        return $prime;
    }
}