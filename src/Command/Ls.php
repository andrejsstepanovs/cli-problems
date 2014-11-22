<?php
namespace App\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class Ls
 *
 * @package     App\Command
 * @name        ls
 * @description List directory
 */
class Ls extends AbstractCommand
{
    protected function configure()
    {
        $this->addArgument('dir', InputArgument::OPTIONAL, 'Directory');
        $this->addOption('ext', 'e', InputOption::VALUE_OPTIONAL, 'Filter files by extension');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $directory = $input->getArgument('dir');
        $extension = $input->getOption('ext');

        $files = scandir($directory);
        foreach ($files as $file) {
            if (!empty($extension)) {
                $fileExtension = pathinfo($directory . DIRECTORY_SEPARATOR . $file, PATHINFO_EXTENSION);
                if (empty($fileExtension) || $fileExtension != $extension) {
                    continue;
                }
            }

            $output->writeln($file);
        }
    }
}