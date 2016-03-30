<?php

namespace Yarik\MicroSymfony\Component\HttpFoundation;

class JsonResponse extends Response
{
    public function __construct($data)
    {
        $this->setContent(json_encode($data));
    }
}