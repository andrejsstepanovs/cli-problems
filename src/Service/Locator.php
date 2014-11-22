<?php

namespace App\Service;

use Symfony\Component\Console\Application;
use App\Command\AbstractCommand;


/**
 * Class Locator
 *
 * @package App\Service
 */
class Locator
{
    const APPLICATION        = 'application';
    const CONFIG             = 'application.config';
    const SERVICE_REFLECTION = 'service.reflection';
    const VALUE_DOCS         = 'value.docs';

    /** @var array */
    private $services = [];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->services[self::CONFIG] = $config;
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        if (!isset($this->services[self::APPLICATION])) {
            $this->services[self::APPLICATION] = $this->setUpApplication(new Application());
        }

        return $this->services[self::APPLICATION];
    }

    /**
     * @return Reflection
     */
    public function getServiceReflection()
    {
        if (!isset($this->services[self::SERVICE_REFLECTION])) {
            $this->services[self::SERVICE_REFLECTION] = new Reflection();
        }

        return $this->services[self::SERVICE_REFLECTION];
    }

    /**
     * @return \App\Value\Docs
     */
    public function getValueDocs()
    {
        if (!isset($this->services[self::VALUE_DOCS])) {
            $this->services[self::VALUE_DOCS] = new \App\Value\Docs();
        }

        return $this->services[self::VALUE_DOCS];
    }

    /**
     * @param Application $application
     *
     * @return Application
     */
    private function setUpApplication(Application $application)
    {
        $commands = $this->services[self::CONFIG]['commands'];
        foreach ($commands as $className) {
            $command = $this->createCommand($className);
            $application->add($command);
        }

        return $application;
    }

    /**
     * @param string $className
     *
     * @return AbstractCommand
     */
    private function createCommand($className)
    {
        $data = $this->getServiceReflection()->getDocsData($className);
        $docs = $this->getValueDocs()->setData($data);

        /** @var AbstractCommand $command */
        $command = new $className(null, $docs);
        if (!$command instanceof AbstractCommand) {
            throw new \RuntimeException('Command needs to extend AbstractCommand');
        }

        return $command;
    }
}
