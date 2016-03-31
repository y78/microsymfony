<?php

namespace App\Main\Controller;

use Yarik\MicroSymfony\Component\Dependency\Container;
use Yarik\MicroSymfony\Component\HttpFoundation\JsonResponse;
use Yarik\MicroSymfony\Component\HttpFoundation\Request;

class CategoryController
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function showAction(Request $request, $id)
    {
        return new JsonResponse($id);
    }
}