<?php
namespace App\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class Problem1
 *
 * @package     App\Command
 * @name        problem1
 * @description https://projecteuler.net/problem=1
 */
class Problem1 extends AbstractCommand
{
    protected function configure()
    {
        $this->addOption('min', 'i', InputOption::VALUE_OPTIONAL, 'Min number', 1);
        $this->addOption('max', 'm', InputOption::VALUE_REQUIRED, 'Max number');
        $this->addOption('and', 'a', InputOption::VALUE_NONE, 'Use AND');
        $this->addOption('divide', 'd', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Divide number');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $min    = $input->getOption('min');
        $max    = $input->getOption('max');
        $and    = $input->getOption('and');
        $divide = $input->getOption('divide');

        $numbers = [];
        for ($i = $min ; $i < $max ; $i++) {
            $found = false;
            foreach ($divide as $dev) {
                if ($and && $i % $dev != 0) {
                    continue 2;
                }

                if ($i % $dev == 0) {
                    $found = true;
                }
            }

            if ($found) {
                $numbers[] = $i;
            }
        }

        $output->writeln($numbers);
        $output->writeln('SUM: ' . array_sum($numbers));
    }
}