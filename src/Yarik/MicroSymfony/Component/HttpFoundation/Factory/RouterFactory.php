<?php

namespace Yarik\MicroSymfony\Component\HttpFoundation\Factory;

use Yarik\MicroSymfony\Component\HttpFoundation\Request;
use Yarik\MicroSymfony\Component\HttpFoundation\Router;
use Yarik\MicroSymfony\Component\Parser\YamlReader;

class RouterFactory
{
    protected $configuration;

    public function __construct(YamlReader $reader, $configPath)
    {
        $this->configuration = $reader->read($configPath);
    }

    public function createRouter(Request $request)
    {
        $router = new Router($request);
        foreach ($this->configuration as $route => $configuration) {
            $data = $this->handleRouteData($route, $configuration);

            foreach ($data as list($name, $resource, $requirements, $defaults)) {
                $router->addRoute($name, $resource, $requirements, $defaults);
            }
        }

        return $router;
    }

    protected function handleRouteData($route, array $data, array $requirements = [], $prefix = '')
    {
        $path = $prefix . (isset($data['path']) ? $data['path'] : '');
        $requirements = $requirements + (isset($data['requirements']) ? $data['requirements'] : []);

        $result = [];
        $handleRoute = true;
        foreach ($data as $key => $value) {
            if (!in_array($key, ['path', 'requirements', 'defaults'])) {
                $handleRoute = false;
                $result = array_merge(
                    $result,
                    $this->handleRouteData($key, $value, $requirements, $path)
                );
            }
        }

        if ($handleRoute) {
            $result[] = [$route, $path, $requirements, $data['defaults']];
        }

        return $result;
    }
}