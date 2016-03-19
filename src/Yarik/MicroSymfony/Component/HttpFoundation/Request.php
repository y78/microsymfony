<?php

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