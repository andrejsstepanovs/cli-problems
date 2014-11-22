<?php

namespace App\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class Problem3
 *
 * @package     App\Command
 * @name        problem3
 * @description https://projecteuler.net/problem=3
 */
class Problem3 extends AbstractCommand
{
    /** @var \App\Service\Prime */
    private $prime;

    /**
     * @return \App\Service\Prime
     */
    public function getPrime()
    {
        if ($this->prime === null) {
            $this->prime = new \App\Service\Prime();
        }

        return $this->prime;
    }

    protected function configure()
    {
        $this->addOption('number', 'x', InputOption::VALUE_REQUIRED, 'Number');
        $this->addOption('prime-count', 'p', InputOption::VALUE_REQUIRED, 'Prime number count', 2000);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $number     = $input->getOption('number');
        $primeCount = $input->getOption('prime-count');
        $primes     = $this->getPrime()->getPrimeNumbers($primeCount);

        $factors = [];
        while ($this->multiply($factors) != $number) {
            $factors = $this->findFactors($number, $primes);
        }

        if (count($factors) == 1) {
            throw new \RuntimeException('Prime factors not found for number ' . $number);
        }

        $output->writeln($this->getEquation($factors, $number));
        $output->writeln('Largest factor: ' . max($factors));
    }

    /**
     * @param array $factors
     * @param int   $number
     */
    private function getEquation(array $factors, $number)
    {
        sort($factors);

        $powers = [];
        foreach (array_unique($factors) as $int) {
            $powers[$int] = 0;
        }
        foreach ($factors as $int) {
            $powers[$int]++;
        }

        $multiply = [];
        foreach ($powers as $int => $power) {
            $multiply[] = $power > 1 ? $int . '^' . $power : $int;
        }

        return implode(' * ', $multiply) . ' = ' . $number;
    }

    /**
     * @param int   $number
     * @param array $primes
     *
     * @return array
     */
    private function findFactors($number, array $primes)
    {
        $data    = [];
        $integer = $number;
        while (!isset($dividable) || !empty($dividable)) {

            $dividable = $this->getPrime()->canBeDividedByPrimes($integer, $primes);
            shuffle($dividable);

            foreach ($dividable as $prime) {
                $data[] = $prime;
                $integer = $integer / $prime;
            }
        }

        return $data;
    }

    /**
     * @param array $numbers
     *
     * @return int
     */
    private function multiply(array $numbers)
    {
        $result = 1;
        foreach ($numbers as $number) {
            $result *= $number;
        }

        return $result;
    }
}