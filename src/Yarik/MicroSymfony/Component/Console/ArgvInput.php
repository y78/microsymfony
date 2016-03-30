<?php

namespace Yarik\MicroSymfony\Component\Console;

class ArgvInput
{
    protected $args = [];
    protected $vars = [];
    protected $commandName;

    public function __construct(array $argv = null)
    {
        if (null === $argv) {
            $argv = $_SERVER['argv'];
        }

        array_shift($argv);

        $this->args = $argv;
        $this->init();
    }

    public function getCommandName()
    {
        return $this->commandName;
    }

    public function get($key)
    {
        return isset($this->vars[$key]) ? $this->vars[$key] : null;
    }

    protected function init()
    {
        $this->commandName = $this->args[0];

        for ($i = 0; $i < count($this->args); $i++) {
            if (mb_strcut($this->args[$i], 0, 2) == '--') {
                $this->vars[mb_strcut($this->args[$i], 2)] =
                    isset($this->args[$i+1]) && mb_strcut($this->args[$i+1], 0, 2) != '--' ?
                        $this->args[++$i] :
                        true
                ;
            }
        }
    }
}