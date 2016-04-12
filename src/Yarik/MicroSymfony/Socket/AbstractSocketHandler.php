<?php

namespace Yarik\MicroSymfony\Socket;

use Yarik\MicroSymfony\Component\Dependency\ContainerInterface;

abstract class AbstractSocketHandler
{
    protected $socket;

    public function __construct(ContainerInterface $container, WebSocket $socket)
    {
        $this->socket = $socket;
    }

    abstract public function onFrame(WebSocketRoute $session, $data, $type);
}
