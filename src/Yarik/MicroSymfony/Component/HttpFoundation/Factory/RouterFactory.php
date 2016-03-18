<?php

namespace Yarik\MicroSymfony\Component\HttpFoundation\Factory;

use Yarik\MicroSymfony\Component\HttpFoundation\Request;
use Yarik\MicroSymfony\Component\HttpFoundation\Router;

class RouterFactory
{
    protected $configuration;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    public function createRouter(Request $request)
    {
        $router = new Router($request);
        foreach ($this->configuration as $route => $configuration) {
            $data = $this->handleRouteData($route, $configuration);

            foreach ($data as list($name, $resource, $requirements)) {
                $router->addRoute($name, $resource, $requirements);
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
            if (!in_array($key, ['path', 'requirements'])) {
                $handleRoute = false;
                $result = array_merge(
                    $result,
                    $this->handleRouteData($key, $value, $requirements, $path)
                );
            }
        }

        if ($handleRoute) {
            $result[] = [$route, $path, $requirements];
        }

        return $result;
    }
}