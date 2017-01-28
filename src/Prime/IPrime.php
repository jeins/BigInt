<?php

namespace ITS\Prime;

interface IPrime{

    /**
     * check is prime with fermat method
     * @param $expectedPrime
     * @param $randNumber
     * @return boolean
     */
    public static function doFermatTest($expectedPrime, $randNumber);

    /**
     * check is prime with euler method
     * @param $expectedPrime
     * @param $randNumber
     * @return boolean
     */
    public static function doEulerTest($expectedPrime, $randNumber);

    /**
     * check is prime with Miller-Rabin method
     * @param $expectedPrime
     * @param $randNumber
     * @param $d
     * @param $s
     * @return mixed
     */
    public static function doMillerRabinTest($expectedPrime, $randNumber, $d, $s);
}