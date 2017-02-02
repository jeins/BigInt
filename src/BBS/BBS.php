<?php

namespace ITS\BBS;

use ITS\BigInt\BigInt;
use ITS\Prime\Prime;

class BBS
{
    /**
     * @var string
     */
    private $start;

    /**
     * @var int
     */
    private $size;

    public function __construct($start, $size = 10)
    {
        $this->start = $start;
        $this->size = $size;
    }

    /**
     * set start
     * @param $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * set size
     * @param $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * generate random BBS
     * @return array
     */
    public function randomBBS()
    {
        $p = $this->getRandomPrime($this->start);
        $q = $this->getRandomPrime($p);
        $n = BigInt::string2BigInt($p)->mulWith(BigInt::string2BigInt($q))->value;
        $s = $this->getSeed($n);
        $z = $s;
        $bits = [];
        $arrZ = [];

        for($i=1; $i<=$this->size; $i++){
            $arrZ[] = $z;
            $bits[] = (gmp_testbit($z,0))?1:0;
            $bigIntOfZ = BigInt::string2BigInt($z);
            $z = $bigIntOfZ->powerMod(2, $n)->value;
        }

        $v = 0;
        $b = '';
        for($i= 0;$i<$this->size;$i++) {
            $v= ($bits[$i]&1)|($v<<1);
            $b .= $bits[$i]+'0';
        }

        return [
            'p' => $p,
            'q' => $q,
            'n' => $n,
            's' => $s,
            'z' => $arrZ,
            'b' => $b,
            'v' => $this->mkBytes(dechex($v))
        ];
    }

    /**
     * get random prime which %4=3
     * @param $n
     * @return string
     */
    private function getRandomPrime($n)
    {
        do{
            $n = gmp_strval(gmp_nextprime($n));
        } while(!Prime::isPrimeEulerWithRandomNum($n, '10') || !BigInt::eq(bcmod($n, '4'), '3'));

        return $n;
    }

    /**
     * get seed
     * @param $n
     * @return string
     */
    private function getSeed($n)
    {
        do{
            $tmpDiv = BigInt::string2BigInt($n)->divWith('4');
            $tmpSub = BigInt::string2BigInt($n)->subWith('1');

            $s = gmp_strval(gmp_random_range($tmpDiv->value, $tmpSub->value));
        } while(!BigInt::eq(BigInt::string2BigInt($n)->gcd($s)->value, '1'));

        return $s;
    }

    private function mkBytes($str)
    {
        $ch= $str[0];
        if($ch=='-') {
            if((strlen($str)&1)==0) {
                $str[0]= '0';
                return '-'.$str;
            }
            return $str;
        } else {
            if((strlen($str)&1)==1) {
                return '0'.$str;
            }
            return $str;
        }
    }
}