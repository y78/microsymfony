<?php

namespace Yarik\MicroSymfony\Component\HttpFoundation;

use Yarik\MicroSymfony\Component\Core\Bag;

class Request
{
    protected $path;
    public $query;
    public $request;
    public $server;

    public function __construct()
    {
        $this->query = new Bag($_GET);
        $this->request = new Bag($_POST);
        $this->server = new Bag($_SERVER);
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