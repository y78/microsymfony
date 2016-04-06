<?php

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