<?php

namespace Yarik\MicroSymfony\Component\Console;

use Yarik\MicroSymfony\Component\Dependency\Container;

class Console
{
    protected $commands;
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function init($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $commands = array_map(function ($path) {
            $matches = [];
            preg_match('/(\w+)Command.php/', $path, $matches);
            return $this->container->getParameter('namespace') . '\\Command\\' . $matches[1] . 'Command';
        }, glob($dir . '/*Command.php'));

        foreach ($commands as $class) {
            $r = new \ReflectionClass($class);
            
            if ($r->isInstantiable()) {
                $this->add(new $class($this->container));
            }
        }
    }

    public function initCommands()
    {
        foreach ($this->container->getParameter('command.dirs') as $dir) {
            $this->init($dir);
        }
    }

    public function add(CommandInterface $command)
    {
        $this->commands[$command->getName()] = $command;
    }

    public function run(ArgvInput $input)
    {
        if (!isset($this->commands[$input->getCommandName()])) {
            throw new \Exception('Нет такой команды');
        }

        $this->commands[$input->getCommandName()]->execute($input);
    }
}