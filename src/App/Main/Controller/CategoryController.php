<?php

namespace App\Main\Controller;

use Yarik\MicroSymfony\Component\Dependency\Container;
use Yarik\MicroSymfony\Component\HttpFoundation\JsonResponse;
use Yarik\MicroSymfony\Component\HttpFoundation\Request;
use Yarik\MicroSymfony\Component\HttpFoundation\Response;

class CategoryController
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function showAction(Request $request, $id)
    {
        $response = new Response();
$response->setContent('
<html>
<head></head>
<body>
    <div style="width: 100%; height: 500px; background: #f0f0f0;">
        
    </div>
</body>
</html>
');
        return $response;
    }
}