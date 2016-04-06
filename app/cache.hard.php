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
  'parameters' => 
  array (
    'mongo.db_name' => 'testdb',
    'Framework.config' => '/Users/yarik/dev/yarik/microsymfony/src/Yarik/MicroSymfony/Resources/config/components.yml',
    'Main.resources' => '/Users/yarik/dev/yarik/microsymfony/src/App/Main/Resources',
    'Main.services' => '/Users/yarik/dev/yarik/microsymfony/src/App/Main/Resources/config/services.yml',
    'Main.routing' => '/Users/yarik/dev/yarik/microsymfony/src/App/Main/Resources/config/routing.yml',
  ),
  'services' => 
  array (
    'router_factory' => 
    array (
      'class' => 'Yarik\\MicroSymfony\\Component\\HttpFoundation\\Factory\\RouterFactory',
      'arguments' => 
      array (
        0 => '@yaml_reader',
        1 => '/Users/yarik/dev/yarik/microsymfony/app/config/routing.yml',
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
    'microtwig' => 
    array (
      'class' => 'Yarik\\MicroSymfony\\MicroTwig\\MicroTwig',
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
        0 => '/Users/yarik/dev/yarik/microsymfony/app',
        1 => '/Users/yarik/dev/yarik/microsymfony/app/config/config.yml',
        2 => '/Users/yarik/dev/yarik/microsymfony/app/config/routing.yml',
        3 => '/Users/yarik/dev/yarik/microsymfony/app/config/mapping.yml',
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
          14 => 'Yarik\\MicroSymfony\\MicroTwig\\MicroTwig',
          15 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\Interpreter',
          16 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\Lexer',
          17 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\AbstractLexer',
          18 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\Struct\\Stack',
          19 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\TokenInterpreter\\ValueInterpreter',
          20 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\TokenInterpreter\\InterpreterInterface',
          21 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\Extension\\ArithmeticExtension',
          22 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\Extension\\Extension',
          23 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\Handler\\ArithmeticHandler',
          24 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\Handler\\LogicHandler',
          25 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\TokenInterpreter\\BinaryOperatorInterpreter',
          26 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\TokenInterpreter\\UnaryLeftInterpreter',
          27 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\TokenInterpreter\\BracketOpenInterpreter',
          28 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\TokenInterpreter\\BracketCloseInterpreter',
          29 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\TokenInterpreter\\PunctuationInterpreter',
          30 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\Extension\\DeclaratorExtension',
          31 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\TokenInterpreter\\DotInterpreter',
          32 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\Extension\\ConditionExtension',
          33 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\TokenInterpreter\\IfInterpreter',
          34 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\TokenInterpreter\\ElseInterpreter',
          35 => 'Yarik\\MicroSymfony\\MicroTwig\\Interpreter\\TokenInterpreter\\EndIfInterpreter',
          36 => 'Yarik\\MicroSymfony\\ODM\\Persistence\\Collection',
          37 => 'Yarik\\MicroSymfony\\ODM\\Persistence\\DocumentManager',
          38 => 'Yarik\\MicroSymfony\\ODM\\Persistence\\DocumentManagerFactory',
          39 => 'Yarik\\MicroSymfony\\ODM\\Persistence\\Hydrator',
          40 => 'Yarik\\MicroSymfony\\ODM\\Persistence\\ObjectManager',
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
        1 => '/Users/yarik/dev/yarik/microsymfony/app/config/mapping.yml',
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
          1 => 'testdb',
        ),
      ),
    ),
    'app.container_wrapper' => 
    array (
      'class' => 'App\\Main\\Container\\ContainerWrapper',
      'arguments' => 
      array (
        0 => '@container',
      ),
    ),
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
    protected $reader;
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

        $this->reader = new YamlReader(new YamlParser(), [
            'kernel.framework_dir' => dirname(dirname(__DIR__)),
            'kernel.root_dir' => $this->rootDir,
            'kernel.project_dir' => dirname($this->rootDir),
            'kernel.env' => $this->env
        ]);

        $this->config = $this->reader->read($this->configPath);
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
            ->setParameter('kernel.framework_dir', dirname(dirname(__DIR__)))
            ->setParameter('kernel.root_dir', $this->rootDir)
            ->setParameter('kernel.project_dir', dirname($this->rootDir))
            ->setParameter('kernel.env', $this->env)
        ;
    }

    public function getContainerClass()
    {
        return Container::class;
    }
}

namespace Yarik\MicroSymfony\Component\Parser;

use Yarik\MicroSymfony\Component\Dependency\Container;
use Yarik\MicroSymfony\Component\Dependency\ContainerInterface;
use Yarik\MicroSymfony\Component\HttpKernel\Kernel;

class YamlReader
{
    protected static $parameterContainer;
    protected $parser;

    public function __construct(YamlParser $parser, array $parameters = [])
    {
        $this->parser = $parser;
        if (!self::$parameterContainer) {
            self::$parameterContainer = new Container([], $parameters);
        }
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

                $resource = self::$parameterContainer->prepareParam($data['resource']);

                if (!file_exists($resource)) {
                    $resource = dirname($path) . '/' . ltrim($resource, '/');
                }

                $import = $this->read($resource);

                foreach ($import as $key => $value) {
                    if (!isset($config[$key])) {
                        $config[$key] = [];
                    }

                    $config[$key] += $value;
                }
            }

            unset($config['imports']);
        }

        if (isset($config['parameters'])) {
            foreach ($config['parameters'] as $key => $value) {
                self::$parameterContainer->setParameter($key, $value);
            }

            foreach ($config['parameters'] as $key => &$value) {
                $value = self::$parameterContainer->getParameter($key);
            }
        }

        array_walk_recursive($config, function (&$value) {
            if (is_string($value)) {
                $value = self::$parameterContainer->prepareParam($value);
            }
        });

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
            $value = preg_replace('/^index.php(.+?)$/', '$1', $value);
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


namespace Yarik\MicroSymfony\MicroTwig;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Extension\ArithmeticExtension;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Extension\ConditionExtension;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Extension\DeclaratorExtension;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Interpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\ValueInterpreter;

class MicroTwig
{
    /** @var Interpreter */
    protected $interpreter;

    /** @var ValueInterpreter $valueInterpreter */
    protected $valueInterpreter;

    public function __construct()
    {
        $this->interpreter = $interpreter = new Interpreter(new Lexer());
        $this->valueInterpreter = new ValueInterpreter($interpreter);
        $interpreter
            ->addTokenInterpreter(Lexer::TYPE_CONSTANT, $this->valueInterpreter)
            ->addExtension(new ArithmeticExtension($interpreter))
            ->addExtension(new DeclaratorExtension($interpreter))
            ->addExtension(new ConditionExtension($interpreter))
        ;
    }

    public function render($file, $parameters = [])
    {
        return $this->getResult(file_get_contents($file), $parameters);
    }

    public function getResult($text, $context = [])
    {
        $this->valueInterpreter->setContext($context);
        $array = $this->splitText('  ' . $text . '  ');

        $result = [];
        foreach ($array as $index => $value) {
            if ($index % 2) {
                $value = $this->interpreter->handle($value);
            }

            $result[] = $value;
        }

        return trim(implode($result));
    }

    protected function splitText($text)
    {
        $text = preg_replace('/\s+/xui', ' ', $text);
        $pattern = '/\{\{(?:.*?)\}\}/xui';
        $left = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);
        preg_match_all($pattern, $text, $right);
        $right = reset($right);

        $result = [];
        for ($i = 0; $i < count($right); $i++) {
            $result[] = $left[$i];
            $result[] = trim(mb_substr($right[$i], 2, -2, 'UTF-8'));
        }

        $result[] = end($left);
        return $result;
    }
}

namespace Yarik\MicroSymfony\MicroTwig\Interpreter;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Extension\Extension;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\AbstractTokenInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Struct\Stack;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\ValueInterpreter;

class Interpreter
{
    protected $lexer;
    protected $interpreters = [];
    protected $completions = [];

    protected $lastToken;
    protected $tokenStack;
    protected $valueStack;
    protected $concatenationHandler;

    public function __construct(Lexer $lexer)
    {
        $this->lexer = $lexer;

        $this->tokenStack = new Stack();
        $this->valueStack = new Stack();
    }

    public function handle($input)
    {
        $this->getTokenStack()->clear();
        $this->getValueStack()->clear();

        $this->lastToken = null;
        $this->lexer->setInput($input);

        while ($data = $this->lexer->next()) {
            // берём следующую лексему и обрабатываем её с помощью сопоставленного интерпретатора
            $current = $this->getTokenInterpreter($data);
            $current->handle($data);

            $this->lastToken = $data;
        }

        while ($interpreter = $this->tokenStack->pop()) {
            $interpreter->flush();
        }

        $result = '';
        while ($value = $this->valueStack->pop()) {
            if (is_array($value)) {
                $value = implode($value);
            }
            
            $result .= $value;
        }

        return $result;
    }

    public function addExtension(Extension $extension)
    {
        foreach ($extension->getTokenInterpreters() as $alias => $interpreter)  {
            $this->addTokenInterpreter($alias, $interpreter);
        }

        return $this;
    }

    public function addTokenInterpreter($alias, AbstractTokenInterpreter $interpreter)
    {
        $this->lexer->addToken($alias, $interpreter->getTokenType());
        $this->interpreters[$alias] = $interpreter;

        return $this;
    }

    public function getTokenStack()
    {
        return $this->tokenStack;
    }

    public function getValueStack()
    {
        return $this->valueStack;
    }

    public function getInterpreter($key)
    {
        if (!isset($this->interpreters[$key])) {
            return null;
        }

        return $this->interpreters[$key];
    }

    public function last()
    {
        return $this->lastToken;
    }

    public function getLexer()
    {
        return $this->lexer;
    }

    public function next()
    {
        return $this->lexer->next();
    }

    public function hasToken($data)
    {
        if (is_numeric($data['value'])) {
            return false;
        }

        if ($data['type'] == 0) {
            return false;
        }

        return isset($this->interpreters[$data['type']]) || isset($this->interpreters[$data['value']]);
    }

    /**
     * @return AbstractTokenInterpreter|null
     */
    protected function getTokenInterpreter($data)
    {
        if (isset($this->interpreters[$data['type']])) {
            return $this->interpreters[$data['type']];
        }

        return $this->interpreters[$data['value']];
    }
}


namespace Yarik\MicroSymfony\MicroTwig\Interpreter;

class Lexer extends AbstractLexer
{
    const TYPE_CONSTANT = 0;
    const TYPE_DECLARATOR = 1;
    const TYPE_BINARY_OPERATOR = 2;
    const TYPE_UNARY_OPERATOR = 3;
    const TYPE_PUNCTUATION = 4;
    const TYPE_END = 5;
    const TYPE_IF = 6;
    const TYPE_ELSE = 7;

    protected $types = [];

    public function addToken($alias, $type)
    {
        $this->types[$alias] = $type;
        return $this;
    }

    public function getCatchablePatterns()
    {
        uksort($this->types, function ($a, $b) {
            return strlen($b) - strlen($a);
        });

        return array_merge([
            '[\@а-яa-z_\\\][а-яa-z0-9_\:\\\]*[а-яa-z0-9_]{1}',
            '(?:[0-9]+(?:[\.][0-9]+)*)(?:e[+-]?[0-9]+)?',
            '\'(?:[^\']|\'\')*\'',
            '"(?:[^"]|"")*"',
            '\?[0-9]*|:[а-яa-z]{1}[a-z0-9_]{0,}'
        ], array_map(function ($item) {
            return str_replace('/', '\/', preg_quote($item));
        }, array_keys($this->types)));
    }

    public function next()
    {
        if ($this->moveNext()) {
            return $this->lookahead;
        }

        return null;
    }

    /** Добавлен модификатор u для поддержки русских символов */
    protected function scan($input)
    {
        static $regex;

        if ( ! isset($regex)) {
            $regex = '/('
                . implode(')|(', $this->getCatchablePatterns()) . ')|'
                . implode('|', $this->getNonCatchablePatterns()) . '/ui'
            ;
        }

        $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE;
        $matches = preg_split($regex, $input, -1, $flags);

        foreach ($matches as $match) {
            $type = $this->getType($match[0]);

            $this->tokens[] = array(
                'value' => $match[0],
                'type'  => $type,
                'position' => $match[1],
            );
        }
    }

    protected function getNonCatchablePatterns()
    {
        return ['\s+', '(.)'];
    }

    protected function getType(&$value)
    {
        if (isset($this->types[$value])) {
            return $this->types[$value];
        }

        if (is_numeric($value) || $value[0] == '\'' || $value[0] == '"') {
            return self::TYPE_CONSTANT;
        }

        return self::TYPE_CONSTANT;
    }
}


namespace Yarik\MicroSymfony\MicroTwig\Interpreter;

/**
 * @fixme скопирован из Doctrine для замены private методов и свойств на protected
 */
abstract class AbstractLexer
{
    protected $tokens = array();

    protected $position = 0;

    protected $peek = 0;

    public $lookahead;

    public $token;

    public function setInput($input)
    {
        $this->tokens = array();
        $this->reset();
        $this->scan($input);
    }

    public function reset()
    {
        $this->lookahead = null;
        $this->token = null;
        $this->peek = 0;
        $this->position = 0;
    }

    public function resetPeek()
    {
        $this->peek = 0;
    }

    public function resetPosition($position = 0)
    {
        $this->position = $position;
    }

    public function isNextToken($token)
    {
        return null !== $this->lookahead && $this->lookahead['type'] === $token;
    }

    public function isNextTokenAny(array $tokens)
    {
        return null !== $this->lookahead && in_array($this->lookahead['type'], $tokens, true);
    }

    public function moveNext()
    {
        $this->peek = 0;
        $this->token = $this->lookahead;
        $this->lookahead = (isset($this->tokens[$this->position]))
            ? $this->tokens[$this->position++] : null;

        return $this->lookahead !== null;
    }

    public function skipUntil($type)
    {
        while ($this->lookahead !== null && $this->lookahead['type'] !== $type) {
            $this->moveNext();
        }
    }

    public function isA($value, $token)
    {
        return $this->getType($value) === $token;
    }

    public function peek()
    {
        if (isset($this->tokens[$this->position + $this->peek])) {
            return $this->tokens[$this->position + $this->peek++];
        } else {
            return null;
        }
    }

    public function glimpse()
    {
        $peek = $this->peek();
        $this->peek = 0;
        return $peek;
    }

    protected function scan($input)
    {
        static $regex;

        if ( ! isset($regex)) {
            $regex = '/(' . implode(')|(', $this->getCatchablePatterns()) . ')|'
                . implode('|', $this->getNonCatchablePatterns()) . '/i';
        }

        $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE;
        $matches = preg_split($regex, $input, -1, $flags);

        foreach ($matches as $match) {
            // Must remain before 'value' assignment since it can change content
            $type = $this->getType($match[0]);

            $this->tokens[] = array(
                'value' => $match[0],
                'type'  => $type,
                'position' => $match[1],
            );
        }
    }

    public function getLiteral($token)
    {
        $className = get_class($this);
        $reflClass = new \ReflectionClass($className);
        $constants = $reflClass->getConstants();

        foreach ($constants as $name => $value) {
            if ($value === $token) {
                return $className . '::' . $name;
            }
        }

        return $token;
    }

    abstract protected function getCatchablePatterns();

    abstract protected function getNonCatchablePatterns();

    abstract protected function getType(&$value);
}


namespace Yarik\MicroSymfony\MicroTwig\Interpreter\Struct;

class Stack
{
    protected $array;

    public function __construct(array $array = [])
    {
        $this->array = $array;
    }

    public function clear()
    {
        $this->array = [];
    }

    public function count()
    {
        return count($this->array);
    }

    public function splice($count)
    {
        if (!$count) {
            return [];
        }

        return array_splice($this->array, -$count);
    }

    public function push($value)
    {
        array_push($this->array, $value);

        return $this;
    }

    public function pop()
    {
        return array_pop($this->array);
    }

    public function end()
    {
        return end($this->array);
    }

    public function toArray()
    {
        return $this->array;
    }
}


namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class ValueInterpreter extends AbstractTokenInterpreter
{
    protected $constants = [];
    protected $context = null;

    public function handle(array $token)
    {
        $value = $token['value'];

        $lastToken = $this->interpreter->getTokenStack()->end();
        if ($lastToken instanceof DotInterpreter) {
            $this->interpreter->getValueStack()->push($value);
            return;
        }

        if (isset($this->constants[$value])) {
            $this->interpreter->getValueStack()->push($this->constants[$value]);
            return;
        }

        if (null !== $contextValue = $this->getKeyFromContext($value)) {
            $value = $contextValue;
        }

        if (is_string($value) && isset($value[0]) && in_array($value[0], ['\'', '"'])) {
            $value = substr($value, 1, -1);
        }

        $this->interpreter->getValueStack()->push($value);
    }

    public function hasConstant($key)
    {
        return isset($this->constants[$key]) || null !== $contextValue = $this->getKeyFromContext($key);
    }

    public function getKeyFromContext($key)
    {
        if (isset($this->context[$key])) {
            return $this->context[$key];
        }

        if (is_object($this->context)) {
            if (method_exists($this->context, $key)) {
                return $this->context->{$key}();
            }

            if (method_exists($this->context, 'get' . ucfirst($key))) {
                return $this->context->{'get' . ucfirst($key)}();
            }

            if (method_exists($this->context, 'is' . ucfirst($key))) {
                return $this->context->{'is' . ucfirst($key)}();
            }

            if (property_exists($this->context, $key)) {
                return $this->context->{$key};
            }
        }

        return null;
    }

    public function addConstant($alias, $value)
    {
        $this->constants[$alias] = $value;
        return $this;
    }

    public function clearConstants()
    {
        $this->constants = [];
    }

    public function setConstants(array $constants)
    {
        $this->constants = $constants;
        return $this;
    }

    public function setContext($context)
    {
        $this->context = $context;
        return $this;
    }

    public function getTokenType()
    {
        return Lexer::TYPE_CONSTANT;
    }
}

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;

use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;

interface InterpreterInterface
{
    public function getLeftPriority();

    public function getRightPriority();

    /**
     * Обрабатывает лексему и помещает в стек, если необходимо
     */
    public function handle(array $token);

    /**
     * Срабатывает после изъятия из стекаа
     * @return mixed
     */
    public function flush();
}


namespace Yarik\MicroSymfony\MicroTwig\Interpreter\Extension;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Handler\ArithmeticHandler;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Handler\LogicHandler;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Interpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\BinaryOperatorInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\BracketOpenInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\BracketCloseInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\PunctuationInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\UnaryLeftInterpreter;

class ArithmeticExtension extends Extension
{
    protected $arithmeticHandler;
    protected $logicHandler;

    public function __construct(Interpreter $interpreter)
    {
        parent::__construct($interpreter);

        $this->arithmeticHandler = new ArithmeticHandler();
        $this->logicHandler = new LogicHandler();
    }

    public function getTokenInterpreters()
    {
        $and = $this->createBinary([$this->logicHandler, 'andOperation'], 1);
        $or  = $this->createBinary([$this->logicHandler, 'orOperation'], 1);
        $not = $this->createUnary([$this->logicHandler, 'not'], 10);

        return [
            '|'  => $this->createBinary([$this->logicHandler, 'byteOr'], 5),

            '+' => $this->createBinary([$this->arithmeticHandler, 'sum'], 3),
            '-' => $this->createBinary([$this->arithmeticHandler, 'difference'], 3, 4),
            '*' => $this->createBinary([$this->arithmeticHandler, 'product'], 5),
            '/' => $this->createBinary([$this->arithmeticHandler, 'division'], 5),

            '(' => new BracketOpenInterpreter($this->interpreter),
            ')' => new BracketCloseInterpreter($this->interpreter),
            ',' => new PunctuationInterpreter($this->interpreter, function ($a) {return $a;}),

            '==' => $this->createBinary([$this->logicHandler, 'equals'], 2),
            '!=' => $this->createBinary([$this->logicHandler, 'notEquals'], 2),
            '>' => $this->createBinary([$this->logicHandler, 'more'], 2),
            '<' => $this->createBinary([$this->logicHandler, 'less'], 2),
            'and' => $and, '&&' => $and,
            'or' => $or, '||' => $or,
            'not' => $not, '!' => $not
        ];
    }
}


namespace Yarik\MicroSymfony\MicroTwig\Interpreter\Extension;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Interpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\DeclaratorInterpreter;

abstract class Extension
{
    protected $interpreter;

    public function __construct(Interpreter $interpreter)
    {
        $this->interpreter = $interpreter;
    }

    abstract public function getTokenInterpreters();
    
    protected function createUnary(callable $callback, $priority)
    {
        $interpreter = new TokenInterpreter\UnaryLeftInterpreter($this->interpreter, $callback, $priority);

        return $interpreter;
    }

    protected function createBinary(callable $callback, $priority, $rightPriority = null)
    {
        $interpreter = new TokenInterpreter\BinaryOperatorInterpreter($this->interpreter, $callback, $priority, $rightPriority);

        return $interpreter;
    }

    protected function createStringOrArrayDeclarator(callable $callback)
    {
        $interpreter = $this->createDeclarator(function ($string) use ($callback) {
            return $this->handleStringOrArray($callback, $string);
        });

        return $interpreter;
    }

    protected function createStringOrArrayDeclaratorWithParam(callable $callback)
    {
        $interpreter = $this->createDeclarator(function ($string, $parameter) use ($callback) {
            if (is_array($string)) {
                return array_map(function ($row) use ($callback, $parameter) {
                    return $callback($row, $parameter);
                }, $string);
            }

            return $callback($string, $parameter);
        });

        return $interpreter;
    }

    protected function createDeclarator(callable $callback)
    {
        $interpreter = new DeclaratorInterpreter($this->interpreter, $callback);
        $interpreter->setPriority(10);

        return $interpreter;
    }

    protected function handleStringOrArray(callable $callback, $string)
    {
        if (is_array($string)) {
            return array_map($callback, $string);
        }

        return $callback($string);
    }
}


namespace Yarik\MicroSymfony\MicroTwig\Interpreter\Handler;

class ArithmeticHandler
{
    public function sum($left, $right)
    {
        if (!is_numeric($left) || !is_numeric($right)) {
            if (is_array($left) && !is_array($right)) {
                return array_map(function ($left) use ($right) {
                    return $this->sum($left, $right);
                }, $left);
            }

            if (is_array($right) && !is_array($left)) {
                return array_map(function ($right) use ($left) {
                    return $this->sum($left, $right);
                }, $right);
            }

            if (is_array($left) && is_array($right)) {
                $result = [];
                foreach ($left as $leftVal) {
                    foreach ($right as $rightVal) {
                        $result[] = $this->sum($leftVal, $rightVal);
                    }
                }

                return $result;
            }

            return $left . $right;
        }

        return $left + $right;
    }

    public function difference($left, $right)
    {
        if (!is_numeric($left) || !is_numeric($right)) {
            return preg_replace('/' . preg_quote((string)$right) . '/xui', '', (string)$left);
        }

        return $left - $right;
    }

    public function product($left, $right)
    {
        if (!is_numeric($left) || !is_numeric($right)) {
            if (is_array($left) && !is_array($right)) {
                return array_map(function ($left) use ($right) {
                    return $left . $right;
                }, $left);
            }

            if (is_array($right) && !is_array($left)) {
                return array_map(function ($right) use ($left) {
                    return $left . $right;
                }, $right);
            }

            return [$left, $right];
        }

        return $left * $right;
    }

    public function division($left, $right)
    {
        return $left / $right;
    }
}


namespace Yarik\MicroSymfony\MicroTwig\Interpreter\Handler;

class LogicHandler
{
    public function notEquals($left, $right)
    {
        return $left != $right;
    }

    public function equals($left, $right)
    {
        return $left == $right;
    }

    public function byteOr($left, $right)
    {
        return $left | $right;
    }

    public function more($a, $b)
    {
        return $a > $b;
    }

    public function less($a, $b)
    {
        return $a < $b;
    }

    public function not($value)
    {
        return !$value;
    }

    public function orOperation($left, $right)
    {
        return $left || $right;
    }

    public function andOperation($left, $right)
    {
        return $left && $right;
    }
}


namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class BinaryOperatorInterpreter extends AbstractTokenInterpreter
{
    public function getTokenType()
    {
        return Lexer::TYPE_BINARY_OPERATOR;
    }
}

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;


use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class UnaryLeftInterpreter extends AbstractTokenInterpreter
{
    protected $priority = 0;

    public function handle(array $token)
    {
        $this->interpreter->getTokenStack()->push($this);
    }

    public function getTokenType()
    {
        return Lexer::TYPE_UNARY_OPERATOR;
    }

    public function getArgumentsCount()
    {
        return 1;
    }
}

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;


use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class BracketOpenInterpreter extends AbstractTokenInterpreter
{
    protected $priority = -1;

    public function handle(array $token)
    {
        $this->interpreter->getTokenStack()->push($this);
    }

    public function flush()
    {
        return ;
    }

    public function getTokenType()
    {
        return Lexer::TYPE_UNARY_OPERATOR;
    }
}

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;


use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class BracketCloseInterpreter extends AbstractTokenInterpreter
{
    protected $priority = 100;

    public function handle(array $token)
    {
        while ($token = $this->interpreter->getTokenStack()->pop()) {
            if ($token instanceof BracketOpenInterpreter) {
                break;
            }

            $token->flush();
        }

        if ($token = $this->interpreter->getTokenStack()->end()) {
            $this->interpreter->getTokenStack()->pop()->flush();
        }
    }

    public function getTokenType()
    {
        return Lexer::TYPE_UNARY_OPERATOR;
    }
}

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class PunctuationInterpreter extends AbstractTokenInterpreter
{
    public function handle(array $token)
    {
    }

    public function getTokenType()
    {
        return Lexer::TYPE_PUNCTUATION;
    }
}

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\Extension;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Handler\StringHandler;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Interpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;
use App\Util\StringUtil;

class DeclaratorExtension extends Extension
{
    public function __construct(Interpreter $interpreter)
    {
        parent::__construct($interpreter);
    }

    public function getTokenInterpreters()
    {
        $interpreters = [
            '.' => new TokenInterpreter\DotInterpreter($this->interpreter, null, 20, 30),
        ];

        return $interpreters;
    }
}


namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;


use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;
use Doctrine\Common\Collections\ArrayCollection;

class DotInterpreter extends BinaryOperatorInterpreter
{
    protected $priority = 1000;

    public function handle(array $token)
    {
        $lexer = $this->interpreter->getLexer();
        $valueStack = $this->interpreter->getValueStack();

        $right = $lexer->peek();

        if ($this->interpreter->hasToken($right)) {
            return;
        }

        $value = $valueStack->pop();

        if ($right['type'] === Lexer::TYPE_CONSTANT) {
            $valueStack->pop();
            $value = $this->getValue($value, $right['value']);

            $valueStack->push($value);
            $this->interpreter->next();
        }
    }

    public function flush()
    {
        if ($this->interpreter->getValueStack()->count() < $this->getArgumentsCount()) {
            return;
        }

        $arguments = $this->interpreter->getValueStack()->splice($this->getArgumentsCount());
        $value = call_user_func_array([$this, 'callback'], $arguments);

        if (null !== $value) {
            $this->interpreter->getValueStack()->push($value);
        }
    }

    protected function getValue($target, $key)
    {
        if (is_array($target) || $target instanceof \ArrayAccess) {
            if (!isset($target[$key])) {
                return null;
            }

            return $target[$key];
        }

        if (!is_object($target)) {
            return null;
        }

        if (method_exists($target, 'get' . ucfirst($key))) {
            return $target->{'get' . ucfirst($key)}();
        }

        if (method_exists($target, 'is' . ucfirst($key))) {
            return $target->{'is' . ucfirst($key)}();
        }

        if (property_exists($target, $key)) {
            return $target->{$key};
        }

        return null;
    }

    public function getTokenType()
    {
        return Lexer::TYPE_BINARY_OPERATOR;
    }
}

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\Extension;

use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\ElseInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\EndIfInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\IfInterpreter;

class ConditionExtension extends Extension
{
    public function getTokenInterpreters()
    {
        $if = new IfInterpreter($this->interpreter);
        $else = new ElseInterpreter($this->interpreter);
        $endif = new EndIfInterpreter($this->interpreter);

        return [
            'if' => $if,
            'else' => $else,
            'end' => $endif,
            ':' => $else,
            ';' => $endif
        ];
    }
}


namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;


use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class IfInterpreter extends DeclaratorInterpreter
{
    protected $priority = 0;

    public function handle(array $token)
    {
        $this->interpreter->getTokenStack()->push($this);
    }

    public function flush()
    {
        if ($value = $this->interpreter->getValueStack()->pop()) {
            return;
        }

        while ($next = $this->interpreter->next()) {
            if (isset($next['type']) && in_array($next['type'], [Lexer::TYPE_ELSE, Lexer::TYPE_END])) {
                break;
            }
        }
    }

    public function getTokenType()
    {
        return Lexer::TYPE_UNARY_OPERATOR;
    }
}

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;


use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class ElseInterpreter extends AbstractTokenInterpreter
{
    protected $priority = -1;

    public function handle(array $token)
    {
        while ($next = $this->interpreter->next()) {
            if (isset($next['type']) && in_array($next['type'], [Lexer::TYPE_ELSE, Lexer::TYPE_END])) {
                break;
            }
        }
    }

    public function flush()
    {
    }

    public function getTokenType()
    {
        return Lexer::TYPE_ELSE;
    }
}

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;


use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class EndIfInterpreter extends AbstractTokenInterpreter
{
    protected $priority = -1;

    public function handle(array $token)
    {
        $this->interpreter->getTokenStack()->push($this);
    }


    public function flush()
    {
    }

    public function getTokenType()
    {
        return Lexer::TYPE_ELSE;
    }
}

namespace Yarik\MicroSymfony\ODM\Persistence;

use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Query;

class Collection
{
    /** @var BulkWrite */
    protected $bulkWrite;
    protected $manager;
    protected $namespace;

    public function __construct(\MongoDB\Driver\Manager $manager, $dbName, $collectionName)
    {
        $this->manager = $manager;
        $this->namespace = $dbName . '.' . $collectionName;
        $this->bulk();
    }

    public function bulk()
    {
        unset($this->bulkWrite);

        $this->bulkWrite = new BulkWrite();
        return $this;
    }

    public function upsert(array $newObj, array $options = [])
    {
        return $this->update(
            ['_id' => $newObj['_id']],
            $newObj,
            $options + ['upsert' => true]
        );
    }

    public function update(array $criteria, $newObj, array $options = [])
    {
        $this->bulkWrite->update($criteria, $newObj, $options);
        return $this;
    }

    public function flush()
    {
        if (!$this->bulkWrite->count()) {
            return null;
        }

        $result = $this->manager->executeBulkWrite($this->namespace, $this->bulkWrite);
        $this->bulk();
        return $result;
    }

    public function find(array $criteria = [], array $sort = [], $limit = null, $skip = null)
    {
        $params = [];
        if ($sort)  $params['sort'] = $sort;
        if ($limit) $params['limit'] = $limit;
        if ($skip)  $params['skip'] = $skip;

        return $this->manager->executeQuery($this->namespace, $query =  new Query($criteria, $params))->toArray();
    }

    public function findOne(array $criteria = [], array $sort = [], $skip = null)
    {
        $result = $this->find($criteria, $sort, 1, $skip);

        if (!$result) {
            return null;
        }

        return (array)reset($result);
    }
}


namespace Yarik\MicroSymfony\ODM\Persistence;

use Yarik\MicroSymfony\ODM\Repository;

class DocumentManager implements ObjectManager
{
    /** @var \MongoDB $db */
    protected $db;
    protected $idsCollection;
    protected $client;
    protected $metadata = [];

    protected $persist = [];
    protected $hydrators = [];
    protected $collections = [];
    protected $repositories = [];

    protected $original = [];
    protected $objects = [];

    public function __construct(\MongoDB\Driver\Manager $client, $dbName, array $metadata)
    {
        $this->client = $client;
        $this->db = $dbName;
        $this->metadata = $metadata;

        $this->idsCollection = new Collection($this->client, $this->db, 'microids');
    }

    public function getRepository($class)
    {
        return $this->repositories[$class] =
            $this-$this->repositories[$class] ??
            new Repository($this, $class)
        ;
    }

    /** @return Collection */
    public function getCollection($class)
    {
        if (isset($this->collections[$class])) {
            return $this->collections[$class];
        }

        $collectionName = $this->metadata[$class]['collection'];
        return $this->collections[$class] = new Collection($this->client, $this->db, $collectionName);
    }

    public function find($class, $id)
    {
        if (null === $data = $this->getCollection($class)->findOne(['_id' => $id])) {
            return null;
        }

        $object = $this->create($class, (array)$data);
        $this->initializeObject($object, $data);

        return $object;
    }

    public function persist($object)
    {
        $this->objects[get_class($object)][spl_object_hash($object)] = $object;

        return $this;
    }

    public function getHydrator($class)
    {
        if (!$hydrator = &$this->hydrators[$class]) {
            return $this->hydrators[$class] = new Hydrator($this, $class, $this->metadata[$class]['mapping']);
        }

        return $hydrator;
    }

    public function create($class, array $data)
    {
        return $this->getHydrator($class)->hydrate($data);
    }

    public function initializeObject($object, $data = [])
    {
        $id = spl_object_hash($object);
        $data = $this->getHydrator($class = get_class($object))->unhydrate($object);

        $this->original[$class][$id] = $data;
        $this->objects[$class][$id] = $object;

        return $this;
    }

    public function flush()
    {
        foreach ($this->objects as $class => $objects) {
            $collection = $this->getCollection($class);

            foreach ($objects as $id => $object) {
                $data = $this->getHydrator($class)->unhydrate($object);

                if (isset($this->original[$class][$id]) && serialize($this->original[$class][$id]) == serialize($data)) {
                    continue;
                }

                if (!isset($data['_id'])) {
                    $lastId = isset($lastId) ? ++$lastId : $this->getLastId($class);
                    $data['_id'] = $lastId;

                    $r = new \ReflectionProperty($class, 'id');
                    $r->setAccessible(true);
                    $r->setValue($object, $lastId);

                    unset($r);
                }

                $collection->upsert($data);
            }

            if (isset($lastId)) {
                $this->setLastId($class, $lastId);
            }

            $collection->flush();
        }

        return $this;
    }

    public function remove($object)
    {
        // TODO: Implement remove() method.
    }

    public function merge($object)
    {
        // TODO: Implement merge() method.
    }

    public function clear($objectName = null)
    {
        // TODO: Implement clear() method.
    }

    public function detach($object)
    {
        // TODO: Implement detach() method.
    }

    public function refresh($object)
    {
        // TODO: Implement refresh() method.
    }

    public function contains($object)
    {
        return isset($this->original[get_class($object)][spl_object_hash($object)]);
    }

    protected function prepareFields($class, $fields)
    {
        foreach ($fields as &$field) {
            if (isset($this->metadata[$class][$field]['name'])) {
                if ($field === '_id') {
                    $field = '_id';
                }

                $field = $this->metadata[$class][$field]['name'];
            }
        }

        if ($fields && !in_array('_id', $fields)) {
            $fields[] = '_id';
        }

        return $fields;
    }

    protected function setLastId($class, $id)
    {
        $this
            ->idsCollection
            ->upsert(['_id' => $class, 'val' => $id])
            ->flush()
        ;

        return $this;
    }

    protected function getLastId($class)
    {
        if (null === $data = $this->idsCollection->findOne(['_id' => $class])) {
            return 1;
        }

        return $data['val'] + 1;
    }
}


namespace Yarik\MicroSymfony\ODM\Persistence;

use Yarik\MicroSymfony\Component\Parser\YamlReader;

class DocumentManagerFactory
{
    protected $configPath;
    protected $config = [];

    public function createDocumentManager(\MongoDB\Driver\Manager $client, $dbName)
    {
        $dm = new DocumentManager($client, $dbName, $this->config);

        return $dm;
    }

    public function __construct(YamlReader $reader, $configPath)
    {
        $this->config = $reader->read($configPath);
    }
}


namespace Yarik\MicroSymfony\ODM\Persistence;

class Hydrator
{
    protected $r;
    protected $class;
    protected $mapping;

    /** @var DocumentManager $manager */
    protected $manager;

    public function __construct(DocumentManager $manager, $class, array $mapping)
    {
        $this->class = $class;
        $this->manager = $manager;
        $this->mapping = $mapping;
        $this->r = new \ReflectionClass($class);
    }

    public function unhydrate($object)
    {
        $r = new \ReflectionObject($object);
        $data = [];

        foreach ($this->mapping as $field => $options) {
            $name = isset($options['name']) ? $options['name'] : $field;

            if (!$r->hasProperty($field)) {
                continue;
            }

            $prop = $r->getProperty($field);
            $prop->setAccessible(true);
            
            if (null !== $value = $this->unhydrateValue($prop->getValue($object), $options)) {
                $data[$name] = $value;
            }
        }

        return $data;
    }

    public function hydrate($data)
    {
        $object = $this->r->newInstanceWithoutConstructor();
        $r = new \ReflectionObject($object);

        foreach ($this->mapping as $field => $options) {
            $name = isset($options['name']) ? $options['name'] : $field;
            if (!isset($data[$name])) {
                continue;
            }

            if (!$r->hasProperty($field)) {
                continue;
            }

            $prop = $r->getProperty($field);
            $prop->setAccessible(true);
            $value = $this->createValue($data[$name], $options);
            $prop->setValue($object, $value);
        }

        return $object;
    }

    public function createValue($data, $options)
    {
        if (null === $data) {
            return null;
        }

        switch ($options['type']) {
            case 'int':     return (int)$data;
            case 'double':  return (double)$data;
            case 'boolean': return (boolean)$data;
            case 'string':  return (string)$data;
            case 'array':   return (array)$data;
            case 'embed':
                return $this
                    ->manager
                    ->create($options['targetDocument'], $data ? (array)$data : $data)
                ;
        }

        return $data;
    }

    protected function unhydrateValue($data, $options)
    {
        if (null === $data) {
            return null;
        }

        switch ($options['type']) {
            case 'int':     return (int)$data;
            case 'double':  return (double)$data;
            case 'boolean': return (boolean)$data;
            case 'string':  return (string)$data;
            case 'array':   return (array)$data;
            case 'embed':
                return $this
                    ->manager
                    ->getHydrator($options['targetDocument'])
                    ->unhydrate($data)
                ;
        }

        return $data;
    }
}


namespace Yarik\MicroSymfony\ODM\Persistence;

interface ObjectManager
{
    public function find($className, $id);

    public function persist($object);

    public function remove($object);

    public function merge($object);

    public function clear($objectName = null);

    public function detach($object);

    public function refresh($object);

    public function flush();

    public function getRepository($className);

    public function initializeObject($obj);

    public function contains($object);
}

