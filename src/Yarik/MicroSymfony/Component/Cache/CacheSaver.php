<?php

namespace Yarik\MicroSymfony\Component\Cache;

use Composer\Autoload\ClassLoader;
use Yarik\MicroSymfony\Component\Cache\Coder\KernelCoder;
use Yarik\MicroSymfony\Component\Cache\Coder\YamlCoder;
use Yarik\MicroSymfony\Component\Parser\YamlParser;
use Yarik\MicroSymfony\Component\Parser\YamlReader;

class CacheSaver
{
    protected $out;
    protected $mappingPath;
    protected $routingPath;
    protected $configPath;
    protected $classes;

    public function __construct($out, $configPath, $routingPath, $mappingPath, array $classes)
    {
        $this->mappingPath = $mappingPath;
        $this->routingPath = $routingPath;
        $this->configPath = $configPath;
        $this->classes = $classes;
        $this->out = $out;
    }

    public function save()
    {
        $loader = new ClassLoader();
        $loader->add('', __DIR__ . '/../../../..');

        $r = new \ReflectionMethod(ClassLoader::class, 'findFileWithExtension');
        $r->setAccessible(true);
        $file = fopen($this->out, 'w+');
        $yamlCoder = new YamlCoder();
        $reader = new YamlReader(new YamlParser());
        $reader->read($this->configPath);

        $config = $yamlCoder->getCode($reader->read($this->configPath));
        $routing = $yamlCoder->getCode($reader->read($this->routingPath));
        $mapping = $yamlCoder->getCode($reader->read($this->mappingPath));

        fwrite($file, "<?php\n\n");
        fwrite($file, (new KernelCoder())->getCode($config, $routing, $mapping));

        foreach ($this->classes as $class) {
            $fname = $r->invoke($loader, $class, '.php');
            $content = preg_replace('/^.*?(namespace.*)$/sxui', "\n\$1\n", file_get_contents($fname));
            fwrite($file, $content);
        }
        
        fclose($file);
    }
    
}