<?php


            namespace Cache;
        
            use Yarik\MicroSymfony\ODM\Persistence\DocumentManagerCachedFactory;
            use Yarik\MicroSymfony\Component\HttpFoundation\Factory\CachedRouterFactory;
            use Yarik\MicroSymfony\Component\HttpFoundation\Request;
            use Yarik\MicroSymfony\Component\HttpFoundation\Response;
            
            class CacheKernel extends \Yarik\MicroSymfony\Component\HttpKernel\Kernel
            {
                protected function initConfig()
                {
                    if ($this->env) {
                        $this->configPath = $this->rootDir . '/config/' . $this->env . '.yml';
                    } else {
                        $this->configPath = $this->rootDir . '/config/config.yml';
                    }
            
                    $this->config = array (
  'services' => 
  array (
    'app.container_wrapper' => 
    array (
      'class' => 'App\\Main\\Container\\ContainerWrapper',
      'arguments' => 
      array (
        0 => '@container',
      ),
    ),
    'router_factory' => 
    array (
      'class' => 'Yarik\\MicroSymfony\\Component\\HttpFoundation\\Factory\\RouterFactory',
      'arguments' => 
      array (
        0 => '@yaml_reader',
        1 => '%kernel.root_dir%/config/routing.yml',
      ),
    ),
    'router' => 
    array (
      'class' => 'Yarik\\MicroSymfony\\Component\\HttpFoundation\\Router',
      'factory' => 
      array (
        'service' => 'router_factory',
        'method' => 'createRouter',
        'arguments' => 
        array (
          0 => '@request',
        ),
      ),
    ),
    'mongo.client' => 
    array (
      'class' => '\\MongoDB\\Driver\\Manager',
      'arguments' => NULL,
    ),
    'mongo.manager.factory' => 
    array (
      'class' => 'Yarik\\MicroSymfony\\ODM\\Persistence\\DocumentManagerFactory',
      'arguments' => 
      array (
        0 => '@yaml_reader',
        1 => '%kernel.root_dir%/config/mapping.yml',
      ),
    ),
    'mongo.manager' => 
    array (
      'class' => 'Yarik\\MicroSymfony\\ODM\\Persistence\\DocumentManager',
      'factory' => 
      array (
        'service' => 'mongo.manager.factory',
        'method' => 'createDocumentManager',
        'arguments' => 
        array (
          0 => '@mongo.client',
          1 => '%mongo.db_name%',
        ),
      ),
    ),
    'yaml_reader' => 
    array (
      'class' => 'Yarik\\MicroSymfony\\Component\\Parser\\YamlReader',
      'arguments' => 
      array (
        0 => '@yaml_parser',
      ),
    ),
    'yaml_parser' => 
    array (
      'class' => 'Yarik\\MicroSymfony\\Component\\Parser\\YamlParser',
    ),
    'cache.saver' => 
    array (
      'class' => 'Yarik\\MicroSymfony\\Component\\Cache\\CacheSaver',
      'arguments' => 
      array (
        0 => '%kernel.root_dir%/cache.php',
        1 => '%kernel.root_dir%/config/config.yml',
        2 => '%kernel.root_dir%/config/routing.yml',
        3 => '%kernel.root_dir%/config/mapping.yml',
        4 => 
        array (
          0 => 'Yarik\\MicroSymfony\\Component\\HttpKernel\\Kernel',
          1 => 'Yarik\\MicroSymfony\\Component\\Parser\\YamlReader',
          2 => 'Yarik\\MicroSymfony\\Component\\Parser\\YamlParser',
          3 => 'Yarik\\MicroSymfony\\Component\\Dependency\\Container',
          4 => 'Yarik\\MicroSymfony\\Component\\Dependency\\ContainerInterface',
          5 => 'Yarik\\MicroSymfony\\Component\\HttpFoundation\\Request',
          6 => 'Yarik\\MicroSymfony\\Component\\HttpFoundation\\ParameterBag',
          7 => 'Yarik\\MicroSymfony\\Component\\HttpFoundation\\Router',
          8 => 'Yarik\\MicroSymfony\\Component\\HttpFoundation\\Factory\\RouterFactory',
          9 => 'Yarik\\MicroSymfony\\Component\\HttpFoundation\\Factory\\CachedRouterFactory',
          10 => 'Yarik\\MicroSymfony\\Component\\HttpFoundation\\Route',
          11 => 'Yarik\\MicroSymfony\\Component\\HttpFoundation\\JsonResponse',
          12 => 'Yarik\\MicroSymfony\\Component\\HttpFoundation\\Response',
          13 => 'Yarik\\MicroSymfony\\ODM\\Persistence\\DocumentManagerCachedFactory',
        ),
      ),
    ),
  ),
  'parameters' => 
  array (
    'mongo.db_name' => 'testdb',
  ),
);
                }
                
                
                /** @return Response */
                public function handleRequest(Request $request)
                {
                    $this->container->set('request', $request);
                    
                    $dmFactory = new DocumentManagerCachedFactory(array (
  'App\\Main\\Document\\Doc' => 
  array (
    'collection' => 'doc',
    'mapping' => 
    array (
      'id' => 
      array (
        'name' => '_id',
        'type' => 'int',
      ),
      'name' => 
      array (
        'type' => 'string',
      ),
      'embed' => 
      array (
        'type' => 'embed',
        'targetDocument' => 'App\\Main\\Document\\DocEmbed',
      ),
    ),
  ),
  'App\\Main\\Document\\DocEmbed' => 
  array (
    'mapping' => 
    array (
      'key1' => 
      array (
        'type' => 'string',
      ),
      'key2' => 
      array (
        'type' => 'string',
      ),
    ),
  ),
));
                    $this->container->set('mongo.manager.factory', $dmFactory);
                    
            
                    $factory = new CachedRouterFactory(array (
  'category_list' => 
  array (
    'path' => '/',
    'defaults' => 
    array (
      '_controller' => 'App\\Main:Category:list',
    ),
  ),
  'category_show' => 
  array (
    'path' => '/{id}',
    'defaults' => 
    array (
      '_controller' => 'App\\Main:Category:show',
    ),
  ),
  'category_edit' => 
  array (
    'path' => '/{id}/edit',
    'defaults' => 
    array (
      '_controller' => 'App\\Main:Category:edit',
    ),
  ),
  'category_remove' => 
  array (
    'path' => '/{id}/remove',
    'defaults' => 
    array (
      '_controller' => 'App\\Main:Category:remove',
    ),
  ),
));
                    
                    $router = $factory->createRouter($request);
                    $this->container->set('router', $router);
                    
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
            }
        
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

namespace Yarik\MicroSymfony\Component\Parser;

class YamlReader
{
    protected $parser;

    public function __construct(YamlParser $parser)
    {
        $this->parser = $parser;
    }

    public function read($path)
    {
        $this->parser->open($path);
        $config = $this->parser->read();
        $this->parser->close();


        if (isset($config['imports'])) {
            foreach ($config['imports'] as $data) {
                if (!isset($data['resource'])) {
                    continue;
                }

                $resource = $data['resource'];
                if (!file_exists($resource)) {
                    $resource = dirname($path) . '/' . ltrim($resource, '/');
                }

                $import = $this->read($resource);
                foreach (['services', 'parameters'] as $key) {
                    if (!isset($config[$key])) {
                        $config[$key] = [];
                    }

                    $config[$key] += isset($import[$key]) ? $import[$key] : [];
                }
            }

            unset($config['imports']);
        }

        return $config;
    }
}

namespace Yarik\MicroSymfony\Component\Parser;

class YamlParser
{
    const TYPE_KEY = 'key';
    const TYPE_ARRAY_ELEMENT_START = 'element_start';
    const TYPE_VALUE = 'value';
    const TYPE_EMPTY = 'empty';

    protected $spaces = [];
    protected $file;
    protected $type = null;
    protected $value = null;
    protected $level = -1;
    protected $line = '';

    protected function handleValue($value)
    {
        if ($value[0] === '{' || $value[0] === '[') {
            $value = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":', $value) . PHP_EOL;
            $value = preg_replace('/([\:\,\[]+)\s*([^\[\\"\s,\]:\}]+)/', '$1"$2"', $value);
            $value = str_replace('\\', '\\\\', $value);

            return json_decode($value, true);
        }

        return $value;
    }

    public function read()
    {
        $stack = []; $len = 0;
        $tree = []; $current = &$tree;
        foreach ($this->parse() as $type) {
            while ($len > $this->level) {
                $current = &$stack[$len-1];
                unset($stack[--$len]);
            }

            if ($this->type === self::TYPE_VALUE) {
                $current = $this->handleValue($this->value);
            }

            if ($this->type === self::TYPE_ARRAY_ELEMENT_START) {
                if (is_null($current)) {
                    $current = [];
                }

                $stack[$len++] = &$current;
                $current[] = null;
                $current = &$current[count($current) - 1];
            }

            if ($this->type === self::TYPE_KEY && $len <= $this->level) {
                if (is_null($current)) {
                    $current = [];
                }

                $stack[$len++] = &$current;
                $current[$this->value] = null;
                $current = &$current[$this->value];
            }
        }

        return $tree;
    }

    protected function parse()
    {
        while (null !== $this->next()) {
            if ($this->line === '') {
                continue;
            }

            if ($this->line == '-') {
                $this->value = [];
                yield $this->type = self::TYPE_ARRAY_ELEMENT_START;
                continue;
            }

            if (preg_match('/^([\.\_\\\\\-\w]+)\:\s*(.*)$/', $this->line, $matches)) {
                $this->value = $matches[1];
                $this->type = self::TYPE_KEY;

                yield $this->type;

                if ('' !== $matches[2]) {
                    $this->level++;
                    $this->value = $matches[2];
                    yield $this->type = self::TYPE_VALUE;

                    $this->level--;
                }
                
                continue;
            }

            if (preg_match('/^-\s*(.*)/', $this->line, $matches)) {
                yield $this->type = self::TYPE_ARRAY_ELEMENT_START;
                $this->level++;

                $this->value = $matches[1];
                yield $this->type = self::TYPE_VALUE;
                $this->level--;
                continue;
            }

            $this->value = $this->line;
            yield $this->type = self::TYPE_VALUE;
        }
    }

    public function next()
    {
        if (false === $line = fgets($this->file)) {
            return null;
        }

        $line = preg_replace('/\#.*$/', '', $line);

        $line = rtrim($line);
        $this->line = ltrim($line);
        if ($this->line === '') {
            return true;
        }

        $spaces = strlen($line) - strlen($this->line);
        while ($this->spaces) {
            if ($spaces <= end($this->spaces)) {
                array_pop($this->spaces);
                $this->level--;

                continue;
            }

            break;
        }

        $this->level++;
        $this->spaces[] = $spaces;

        return true;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function close()
    {
        fclose($this->file);
    }

    public function open($path)
    {
        $this->file = fopen($path, 'r');
    }
}

namespace Yarik\MicroSymfony\Component\Dependency;

class Container implements ContainerInterface
{
    protected $config = [];
    protected $parameters = [];
    protected $services = [];

    public function __construct(array $config, array $parameters)
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

    private function prepareParam($param)
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

namespace Yarik\MicroSymfony\Component\Dependency;

interface ContainerInterface
{
    public function set($id, $service);

    public function get($id);

    public function setParameter($id, $value);

    public function getParameter($id);
}

namespace Yarik\MicroSymfony\Component\HttpFoundation;

class Request
{
    protected $path;
    public $query;
    public $request;
    public $server;

    public function __construct()
    {
        $this->query = new ParameterBag($_GET);
        $this->request = new ParameterBag($_POST);
        $this->server = new ParameterBag($_SERVER);
    }

    public function getPath()
    {
        if ($this->path) {
            return $this->path;
        }

        if (null !== $value = $this->server->get('PATH_INFO')) {
            return $this->path = $value;
        }

        return '';
    }
}

namespace Yarik\MicroSymfony\Component\HttpFoundation;

class ParameterBag implements \Iterator
{
    protected $data = [];

    public function __construct(array $data = null)
    {
        if ($data) {
            $this->data = $data;
        }
    }

    public function has($key)
    {
        return isset($this->data[$key]);
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function get($key, $default = null)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return $default;
    }

    public function all()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function current()
    {
        return current($this->data);
    }

    public function next()
    {
        return next($this->data);
    }

    public function key()
    {
        return key($this->data);
    }

    public function valid()
    {
        return current($this->data);
    }

    public function rewind()
    {
        return reset($this->data);
    }

}

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

namespace Yarik\MicroSymfony\Component\HttpFoundation\Factory;

use Yarik\MicroSymfony\Component\HttpFoundation\Request;
use Yarik\MicroSymfony\Component\HttpFoundation\Router;
use Yarik\MicroSymfony\Component\Parser\YamlReader;

class CachedRouterFactory
{
    protected $configuration;

    public function __construct(array $config)
    {
        $this->configuration = $config;
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

namespace Yarik\MicroSymfony\Component\HttpFoundation;

class Route
{
    public $parameters;

    /** @var ParameterBag $defaults */
    public $defaults;

    protected $name;

    public function __construct(array $paramters = [])
    {
        $this->parameters = new ParameterBag();

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

    public function get($parameter)
    {
        return $this->defaults->get($parameter);
    }

    public function intersectParameters(array $parameters)
    {
        $parameters = array_intersect_key($this->parameters->all(), $parameters);
        $this->parameters = new ParameterBag($parameters);
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

namespace Yarik\MicroSymfony\Component\HttpFoundation;

class JsonResponse extends Response
{
    public function __construct($data)
    {
        $this->setContent(json_encode($data));
    }
}

namespace Yarik\MicroSymfony\Component\HttpFoundation;

class Response
{
    protected $content = '';
    protected $headers = [
        'Content-Type' => 'UTF-8'
    ];

    public function __construct()
    {
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function handle()
    {

    }
    public function sendHeaders()
    {
        if (headers_sent()) {
            return $this;
        }

        foreach ($this->headers as $name => $value) {
            header($name . ':' . $value);
        }

        return $this;
    }

    public function sendContent()
    {
        echo $this->content;

        return $this;
    }

    public function send()
    {
        return $this
            ->sendHeaders()
            ->sendContent()
        ;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function hasHeader($key)
    {
        return isset($this->headers[$key]);
    }

    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function removeHeader($key)
    {
        unset($this->headers[$key]);
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }
}

namespace Yarik\MicroSymfony\ODM\Persistence;

use Yarik\MicroSymfony\Component\Parser\YamlReader;

class DocumentManagerCachedFactory
{
    protected $configPath;
    protected $config = [];

    public function createDocumentManager(\MongoDB\Driver\Manager $client, $dbName)
    {
        $dm = new DocumentManager($client, $dbName, $this->config);

        return $dm;
    }

    public function __construct(array $config)
    {
        $this->config = $config;
    }
}

