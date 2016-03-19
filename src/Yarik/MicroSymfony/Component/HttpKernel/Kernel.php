<?php

namespace Yarik\MicroSymfony\Component\HttpFoundation;

use Yarik\MicroSymfony\Component\Dependency\Container;

class Kernel
{
    protected $rootDir;
    protected $env;

    /** @var Container $container */
    protected $container;
    protected $config;

    public function __construct($env)
    {
        $this->env = $env;
        $this->rootDir = dirname((new \ReflectionObject($this))->getFileName());
        $this->initContainer();
    }

    protected function initContainer()
    {
        $class = $this->getContainerClass();
        $this->container = new $class($this->config['services']);
        $this->container->set('kernel', $this);
    }

    protected function initConfiguration()
    {
        $this->config = [
            'services' => []
        ];
    }

    public function getContainerClass()
    {
        return Container::class;
    }
}