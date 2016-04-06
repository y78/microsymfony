<?php

namespace Yarik\MicroSymfony\Component\Dependency;

class Container implements ContainerInterface
{
    protected $config = [];
    protected $parameters = [];
    protected $services = [];

    public function __construct(array $config = [], array $parameters = [])
    {
        $this->config = $config;
        $this->parameters = $parameters;
    }

    public function set($id, $service)
    {
        $this->services[$id] = $service;
        return $this;
    }

    public function setParameter($id, $value)
    {
        $this->parameters[$id] = $value;
        return $this;
    }

    public function getParameter($id)
    {
        return $this->prepareParam($this->parameters[$id]);
    }

    public function getParameters()
    {
        return $this->parameters;
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

        if (isset($config['factory'])) {
            $factoryConfig = $config['factory'];
            $factory = $this->get($factoryConfig['service']);
            $arguments = isset($factoryConfig['arguments']) ?
                $this->prepareArguments($factoryConfig['arguments']) :
                []
            ;

            return $this->services[$id] =
                call_user_func_array([$factory, $factoryConfig['method']], $arguments)
            ;
        }

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

        $arg = $this->prepareParam($arg);

        if (is_array($arg)) {
            return array_map(function ($arg) {
                return $this->prepareArgument($arg);
            }, $arg);
        }

        if ($arg && $arg[0] == '@') {
            return $this->get(mb_strcut($arg, 1));
        }

        return $arg;
    }

    public function prepareParam($param)
    {
        if (is_array($param)) {
            return array_map(function ($param) {
                return $this->prepareParam($param);
            }, $param);
        }

        if (preg_match('/^\%([\w\.\_\-]+)\%$/', $param, $matches)) {
            return $this->getParameter($matches[1]);
        }

        $param = preg_replace_callback('/\%([\w\.\_\-]+)\%/', function ($match) {
            return $this->getParameter($match[1]);
        }, $param);

        return $param;
    }
}