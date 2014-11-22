<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Value\Docs;


/**
 * Class AbstractCommand
 *
 * @package App\Command
 */
class AbstractCommand extends Command
{
    /** @var Docs */
    private $docs;

    /**
     * @param null|string $name
     * @param Docs        $docs
     */
    public function __construct($name = null, Docs $docs = null)
    {
        if (!empty($docs)) {
            $this->docs = clone $docs;

            $this->setName($this->getCommandName());
            $this->setDescription($this->docs->getDescription());

            // initialize only if docs is available
            parent::__construct($name);
        }
    }

    /**
     * @param Docs $docs
     *
     * @return $this
     */
    public function setDocs(Docs $docs)
    {
        $this->docs = $docs;

        return $this;
    }

    /**
     * @return string
     */
    protected function getCommandName()
    {
        try {
            $name = $this->docs->getName();

        } catch (\RuntimeException $exc) {
            // if docs name is not provided get command name from class name
            $class = get_class($this);
            $parts = explode('\\', $class);
            $name  = strtolower(implode(':', array_slice($parts, 2)));
        }

        return $name;
    }
}