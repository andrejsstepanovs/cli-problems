<?php

namespace App\Service;


/**
 * Class Prime
 *
 * @package App\Service
 */
class Prime
{
    /** @var array */
    private $dividable = [];

    /**
     * @param int $count
     *
     * @return array
     */
    public function getPrimeNumbers($count)
    {
        $numbers = [];
        $integer = 1;

        while (count($numbers) < $count) {
            $integer++;
            if ($this->isPrime($integer)) {
                $numbers[] = $integer;
            }
        }

        return $numbers;
    }

    /**
     * @param int $integer
     *
     * @return bool
     */
    public function isPrime($integer)
    {
        for ($divide = 2 ; $divide < $integer; $divide++) {
            if ($integer % $divide == 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param int   $integer
     * @param array $primes
     *
     * @return array
     */
    public function canBeDividedByPrimes($integer, array $primes)
    {
        if (!empty($this->dividable[$integer])) {
            return $this->dividable[$integer];
        }

        $result = [];

        foreach ($primes as $prime) {
            if ($prime > $integer) {
                break;
            }

            if ($integer % $prime == 0) {
                $result[] = $prime;
            }
        }

        $this->dividable[$integer] = $result;

        return $result;
    }
}