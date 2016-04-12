<?php

namespace Yarik\MicroSymfony\Socket;

class WebSocketRoute extends \PHPDaemon\WebSocket\Route
{
    /** @var WebSocket $app */
    public $app;
    public $client;
    public $id;

    public function __construct($client, $app)
    {
        $this->client = $client;
        $this->app = $app;
        
    }

    public function onFrame($data, $type)
    {
        $this->app->handle($this, $data, $type);
    }

    public function onFinish()
    {
        unset($this->appInstance->sessions[$this->id]);
    }
}