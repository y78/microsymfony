<?php

namespace App\Main\Command;

use App\Main\Container\ContainerWrapper;
use Yarik\MicroSymfony\Component\Dependency\ContainerInterface;

abstract class BaseCommand extends \Yarik\MicroSymfony\Component\Console\BaseCommand
{
    /**
     * @var ContainerWrapper $container
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container->get('app.container_wrapper'));
    }
}