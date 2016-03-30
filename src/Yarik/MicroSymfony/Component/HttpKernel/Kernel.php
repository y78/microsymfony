<?php

namespace Yarik\MicroSymfony\Component\HttpKernel;

use Yarik\MicroSymfony\Component\Dependency\Container;
use Yarik\MicroSymfony\Component\HttpFoundation\Request;
use Yarik\MicroSymfony\Component\HttpFoundation\Response;
use Yarik\MicroSymfony\Component\HttpFoundation\Router;
use Yarik\MicroSymfony\Component\Parser\YamlParser;
use Yarik\MicroSymfony\Component\Parser\YamlReader;

class Kernel
{
    protected $rootDir;
    protected $configPath;
    protected $env;

    /** @var Container $container */
    protected $container;
    protected $config;

    public function __construct($env)
    {
        $this->env = $env;
        $this->rootDir = dirname((new \ReflectionObject($this))->getFileName());

        $this->initConfig();
        $this->initContainer();
    }

    public function getContainer()
    {
        return $this->container;
    }

    /** @return Response */
    public function handleRequest(Request $request)
    {
        $this->container->set('request', $request);

        /** @var Router $router */
        $router = $this->container->get('router');
        $route = $router->getRoute();
        $controller = $route->get('_controller');
        preg_match('/^(.*?)\:(.*?)\:(.*?)$/', $controller, $matches);
        $class = $matches[1] . '\\Controller\\' . $matches[2] . 'Controller';
        $instance = new $class($this->container);

        return $this->callMethodArray(
            $instance,
            $matches[3] . 'Action',
            $route->parameters->all() + ['request' => $request]
        );
    }

    protected function callMethodArray($instance, $method, array $params)
    {
        $r = new \ReflectionMethod(get_class($instance), $method);
        $args = array_flip(array_map(function (\ReflectionParameter $parameter) {
            return $parameter->getName();
        }, $r->getParameters()));

        foreach ($params as $key => $value) {
            $args[$key] = $value;
        }

        return call_user_func_array([$instance, $method], $args);
    }

    protected function initConfig()
    {
        if ($this->env) {
            $this->configPath = $this->rootDir . '/config/' . $this->env . '.yml';
        } else {
            $this->configPath = $this->rootDir . '/config/config.yml';
        }

        $reader = new YamlReader(new YamlParser());

        $this->config = $reader->read($this->configPath);
    }

    protected function initContainer()
    {
        $class = $this->getContainerClass();
        $services = $this->config['services'];
        $parameters = isset($this->config['parameters']) ? $this->config['parameters'] : [];

        $this->container = new $class($services, $parameters);
        $this
            ->container
            ->set('kernel', $this)
            ->set('container', $this->container)
            ->setParameter('kernel.root_dir', $this->rootDir)
            ->setParameter('kernel.env', $this->env)
        ;
    }

    public function getContainerClass()
    {
        return Container::class;
    }
}