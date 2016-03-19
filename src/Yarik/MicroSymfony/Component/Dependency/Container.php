<?php

namespace Yarik\MicroSymfony\Component\Dependency;

class Container
{
    protected $config = [];
    protected $services = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function set($id, $service)
    {
        $this->services[$id] = $service;
        return $this;
    }

    public function get($id)
    {
        if (isset($this->services[$id])) {
            return $this->services[$id];
        }

        if (!$config = &$this->config[$id]) {
            throw new \Exception('Service ' . $id . ' not found');
        }

        return $this->init($id, $config);
    }

    public function init($id, array $config = [])
    {
        $reflect = new \ReflectionClass($config['class']);
        return $this->services[$id] =
            $reflect->newInstanceArgs(isset($config['arguments']) ?
                $this->prepareArguments($config['arguments']) :
                []
            )
        ;
    }

    private function prepareArguments(array $args)
    {
        return array_map(function ($arg) {
            return $this->prepareArgument($arg);
        }, $args);
    }

    private function prepareArgument($arg)
    {
        if (!is_string($arg)) {
            return $arg;
        }

        if ($arg && $arg[0] == '@') {
            return $this->get(mb_strcut($arg, 1));
        }

        return $arg;
    }
}