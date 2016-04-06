<?php

namespace App\Main\Controller;

use App\Main\Container\ContainerWrapper;
use App\Main\Document\Doc;
use Yarik\Admitad\AdmitadPixel;
use Yarik\MicroSymfony\Component\Controller;
use Yarik\MicroSymfony\Component\Dependency\ContainerInterface;
use Yarik\MicroSymfony\Component\HttpFoundation\JsonResponse;
use Yarik\MicroSymfony\Component\HttpFoundation\Request;
use Yarik\MicroSymfony\Component\HttpFoundation\Response;

abstract class BaseController extends Controller
{
    /** @var ContainerWrapper */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container->get('app.container_wrapper'));
    }

    public function render($path, array $parameters = [], Response $response = null)
    {
        return parent::render($this->container->getParameter('Main.resources') . '/view/' . $path, $parameters, $response);
    }
}