<?php

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