<?php

namespace Yarik\MicroSymfony\Component\HttpFoundation;

use Yarik\MicroSymfony\Component\HttpFoundation\ParameterBag;

class Router
{
    protected $routes = [];
    protected $parameters = [];
    protected $requirements = [];
    protected $defaults = [];
    protected $regexprs = [];
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->routes = new ParameterBag();
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getRequirements()
    {
        return $this->requirements;
    }

    public function getRegexprs()
    {
        return $this->regexprs;
    }

    public function addRoute($name, $resource, $requirements = null, $defaults = null)
    {
        $this->routes->set($name, $resource);
        $this->defaults[$name] = $defaults;

        if ($requirements) {
            $this->requirements[$name] = $requirements;
        }

        return $this;
    }

    public function setRegexprs(array $regexprs)
    {
        $this->regexprs = $regexprs;
        return $this;
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getRoute()
    {
        if (!$this->regexprs) {
            $this->compile();
        }
        
        foreach ($this->regexprs as $regexpr) {
            if (preg_match($regexpr, $this->request->getPath(), $matches)) {
                $route = new Route($matches);
                $route->intersectParameters($this->parameters[$route->getName()]);
                $route->defaults = new ParameterBag($this->defaults[$route->getName()]);

                return $route;
            }
        }

        return null;
    }

    protected function compile()
    {
        $parts = [];
        foreach ($this->routes as $route => $resource) {
            $parts[] = self::getRegexp($resource, $route);
        }
        
        $regex = '/' . implode('|', $parts) . '/';
        $this->regexprs[] = $regex;
    }

    public static function split($value)
    {
        preg_match_all('/(.*?)(\{(\w+)\}|$)/', $value, $matches);
        $result = [];
        for ($i = 0; $i < count(reset($matches)); $i++) {
            if ($matches[1][$i]) {
                $result[] = $matches[1][$i];
            }

            if ($matches[2][$i]) {
                $result[] = $matches[2][$i];
            }
        }

        return $result;
    }

    public function getRegexp($value, $routeName = '')
    {
        $split = self::split($value);
        $parts = array_map(function ($value) use ($routeName) {
            if ($value[0] == '{' && $value[strlen($value)-1] == '}') {
                $value = substr($value, 1, -1);
                $exp = isset($this->requirements[$routeName][$value]) ?
                    $this->requirements[$routeName][$value] :
                    '.+?'
                ;

                $this->parameters[$routeName][$value] = $exp;

                return '(?P<__' . $routeName . '__' . $value . '>' . $exp . ')';
            }

            return preg_quote($value, '/');
        }, $split);

        $exp = '^' . implode($parts) . '$';
        return $exp;
    }
}