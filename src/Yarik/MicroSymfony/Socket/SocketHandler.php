<?php

namespace Yarik\MicroSymfony\Socket;

use Yarik\MicroSymfony\Component\Dependency\ContainerInterface;

class SocketHandler
{
    protected $container;
    protected $socket;

    final public function __construct(ContainerInterface $container = null, WebSocket $socket)
    {
        $this->container = $container;
        $this->socket = $socket;
    }

    public function onFrame(WebSocketRoute $session, $data, $type)
    {
        $session->client->sendFrame('test', 'STRING');
    }
}
