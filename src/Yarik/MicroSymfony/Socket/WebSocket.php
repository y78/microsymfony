<?php

namespace Yarik\MicroSymfony\Socket;

class WebSocket extends \PHPDaemon\Core\AppInstance
{
    /** @var SocketHandler $handler */
    protected $handler;
    protected $routeName = 'ws';
    public $enableRPC = true;
    public $sessions = array();

    public function onReady()
    {
        require_once __DIR__ . '/../../../../vendor/autoload.php';
        require_once __DIR__ . '/../../../../app/AppKernel.php';

        $kernel = new \AppKernel('socket');
        $container = $kernel->getContainer();
        $class = $container->getParameter('socket.handler');
        $this->handler = new $class($kernel->getContainer(), $this);

        \PHPDaemon\Servers\WebSocket\Pool::getInstance()->addRoute($this->routeName, function ($client) {
            $session = new WebSocketRoute($client, $this);
            $session->id = uniqid();
            $this->sessions[$session->id] = $session;

            return $session;
        });
    }

    public function setTimeInterval(callable $callback, $interval)
    {
        \PHPDaemon\Core\Timer::add(function($event) use ($callback, $interval) {
            $callback();
            $this->setTimeInterval($callback, $interval);
            $event->finish();
        }, $interval);
    }

    public function sendAll($message)
    {
        $this->broadcastCall('sendBcMessage', [$message]);
    }

    public function handle(WebSocketRoute $route, $data, $type)
    {
        $this->handler->onFrame($route, $data, $type);
    }

    public function sendBcMessage($message)
    {
        foreach($this->sessions as $id => $session) {
            $session->client->sendFrame($message, 'STRING');
        }
    }

}
