<?php

namespace Yarik\MicroSymfony\Component;

use Composer\Autoload\ClassLoader;
use Yarik\MicroSymfony\Component\Cache\Coder\KernelCoder;
use Yarik\MicroSymfony\Component\Cache\Coder\YamlCoder;
use Yarik\MicroSymfony\Component\Dependency\ContainerInterface;
use Yarik\MicroSymfony\Component\Form\FormBuilder;
use Yarik\MicroSymfony\Component\HttpFoundation\Response;
use Yarik\MicroSymfony\Component\Parser\YamlParser;
use Yarik\MicroSymfony\Component\Parser\YamlReader;

class Controller
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function createFormBuilder($data = [], $type = null)
    {
        return new FormBuilder('form', $type, $data);
    }

    public function createForm($type, $data = null)
    {
        return $this->createFormBuilder($data, $type)->getForm();
    }

    public function createGetForm($type, $data = null)
    {
        return $this->createFormBuilder($data, $type)->setMethod('get')->getForm();
    }

    public function render($path, array $parameters = [], Response $response = null)
    {
        if (null === $response) {
            $response = new Response();
        }

        $content = $this->container->get('microtwig')->render($path, $parameters);
        $response->setContent($content);

        return $response;
    }
}