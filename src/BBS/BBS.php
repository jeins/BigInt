<?php

namespace ITS\BBS;

use ITS\BigInt\BigInt;

class BBS
{
    /**
     * @var BigInt
     */
    private $seed;

    /**
     * @var int
     */
    private $size;

    public function __construct(BigInt $s, int $size = 10)
    {
        $this->seed = $s;
        $this->size = $size;
    }

    public function randomBBS()
    {

    }

    private function getN()
    {

    }
}