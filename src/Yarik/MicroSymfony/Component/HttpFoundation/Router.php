<?php

namespace Yarik\MicroSymfony\Component\HttpFoundation;

use Yarik\MicroSymfony\Component\Core\Bag;

class Router
{
    protected $routes = [];
    protected $regexprs = [];
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->routes = new Bag();
    }

    public function addRoute($name, $resource)
    {
        $this->routes->set($name, $resource);
        return $this;
    }

    public function getRoute()
    {
        if (!$this->regexprs) {
            $this->compile();
        }
        
        foreach ($this->regexprs as $regexpr) {
            if (preg_match($regexpr, $this->request->getPath(), $matches)) {
                return new Route($matches);
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

    public static function getRegexp($value, $routeName = '')
    {
        $split = self::split($value);
        $parts = array_map(function ($value) use ($routeName) {
            return $value[0] == '{' && $value[strlen($value)-1] == '}' ?
                '(?P<__' . $routeName . '__' .substr($value, 1, -1) . '>.+?)' :
                preg_quote($value, '/')
            ;
        }, $split);

        $exp = '^' . implode($parts) . '$';
        return $exp;
    }
}