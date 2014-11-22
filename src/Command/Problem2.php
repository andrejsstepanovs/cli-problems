<?php
namespace App\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class Problem2
 *
 * @package     App\Command
 * @name        problem2
 * @description https://projecteuler.net/problem=2
 */
class Problem2 extends AbstractCommand
{
    const FIRST  = 'first';
    const SECOND = 'second';

    protected function configure()
    {
        $this->addOption('first', 'a', InputOption::VALUE_OPTIONAL, 'First number', 1);
        $this->addOption('second', 'b', InputOption::VALUE_OPTIONAL, 'Second number', 2);
        $this->addOption('max', 'm', InputOption::VALUE_REQUIRED, 'Max number');
        $this->addOption('even', 'e', InputOption::VALUE_NONE, 'Even numbers');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $first  = $input->getOption('first');
        $second = $input->getOption('second');
        $max    = $input->getOption('max');
        $even   = $input->getOption('even');

        $numbers = [self::FIRST => $first, self::SECOND => $second];
        $list = array_values($numbers);

        $iterator = 0;
        $number   = 0;
        while ($number <= $max) {
            $iterator++;
            $number                = $numbers[self::FIRST] + $numbers[self::SECOND];
            $numbers[self::FIRST]  = $numbers[self::SECOND];
            $numbers[self::SECOND] = $number;
            $list[]                = $number;
        }

        if ($even) {
            $list = array_filter($list, function ($number) {
                    return $number % 2 == 0;
                }
            );
        }

        $output->writeln($list);
        $output->writeln('Iterations: ' . $iterator);
        $output->writeln('SUM: ' . array_sum($list));
    }
}