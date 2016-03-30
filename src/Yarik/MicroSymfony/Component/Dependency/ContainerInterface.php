<?php

namespace Yarik\MicroSymfony\Component\Dependency;

interface ContainerInterface
{
    public function set($id, $service);

    public function get($id);

    public function setParameter($id, $value);

    public function getParameter($id);
}