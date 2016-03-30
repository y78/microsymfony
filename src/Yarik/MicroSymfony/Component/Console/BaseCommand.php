<?php

namespace Yarik\MicroSymfony\Component\Console;

use Yarik\MicroSymfony\Component\Dependency\Container;
use Yarik\MicroSymfony\Component\Dependency\ContainerInterface;

abstract class BaseCommand implements CommandInterface
{
    /**
     * @var Container $container
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    abstract public function getName();
    
    abstract public function execute(ArgvInput $input);
}