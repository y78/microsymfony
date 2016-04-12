<?php

namespace Yarik\Microsymfony\Command;

use Yarik\MicroSymfony\Component\Console\ArgvInput;
use Yarik\MicroSymfony\Component\Console\BaseCommand;
use Yarik\MicroSymfony\Socket\WebSocket;

class SocketCommand extends BaseCommand
{
    public function execute(ArgvInput $input)
    {
        $boot = new \Yarik\MicroSymfony\Socket\SocketBootstrap();
        $boot->boot($input->get('command'), $this->getSocketClass(), $this->getConfig());
    }

    /** @return WebSocket */
    protected function getSocketClass()
    {
        return \Yarik\MicroSymfony\Socket\WebSocket::class;
    }

    protected function getConfig()
    {
        return file_get_contents($this->container->getParameter('socket.config'));
    }

    public function getName()
    {
        return 'socket';
    }
}