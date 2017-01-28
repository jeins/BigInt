<?php

namespace ITS\Prime;

interface IPrime{

    /**
     * check is prime with fermat method
     * @param $expectedPrime
     * @param $randNumber
     * @return boolean
     */
    public static function doFermatPseudoPrime($expectedPrime, $randNumber);

    /**
     * check is prime with euler method
     * @param $expectedPrime
     * @param $randNumber
     * @return boolean
     */
    public static function doEulerPseudoPrime($expectedPrime, $randNumber);

    /**
     * check is prime with Miller-Rabin method
     * @param $expectedPrime
     * @param $randNumber
     * @return boolean
     */
    public static function doMrPseudoPrime($expectedPrime, $randNumber);
}