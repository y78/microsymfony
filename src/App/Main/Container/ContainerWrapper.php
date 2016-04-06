<?php

namespace App\Main\Container;

use Yarik\MicroSymfony\Component\Dependency\Container;
use Yarik\MicroSymfony\Component\Dependency\ContainerInterface;
use Yarik\MicroSymfony\MicroTwig\MicroTwig;
use Yarik\MicroSymfony\ODM\Persistence\DocumentManager;

class ContainerWrapper implements ContainerInterface
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /** @return DocumentManager */
    public function getDocumentManager()
    {
        return $this->container->get('mongo.manager');
    }

    /** @return MicroTwig */
    public function getTwig()
    {
        return $this->container->get('microtwig');
    }

    public function set($id, $service)
    {
        $this->container->set($id, $service);
        return $this;
    }

    public function get($id)
    {
        return $this->container->get($id);
    }

    public function setParameter($id, $value)
    {
        $this->container->setParameter($id, $value);
        return $this;
    }

    public function getParameter($id)
    {
        return $this->container->getParameter($id);
    }
}