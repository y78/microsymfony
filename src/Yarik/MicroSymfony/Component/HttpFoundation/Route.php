<?php

namespace Yarik\MicroSymfony\Component\HttpFoundation;

use Yarik\MicroSymfony\Component\Core\Bag;

class Route
{
    protected $name;
    public $parameters;

    public function __construct(array $paramters = [])
    {
        $this->parameters = new Bag();
        foreach ($paramters as $key => $value) {
            if (!is_string($key)) {
                continue;
            }

            if (!preg_match('/^__(?P<route>.+?)__(?P<param>.+?)$/', $key, $matches)) {
                continue;
            }

            $this->name = $matches['route'];
            $this->parameters->set($matches['param'], $value);
        }
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
}