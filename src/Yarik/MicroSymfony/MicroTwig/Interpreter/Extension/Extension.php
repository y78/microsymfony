<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\Extension;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Interpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\DeclaratorInterpreter;

abstract class Extension
{
    protected $interpreter;

    public function __construct(Interpreter $interpreter)
    {
        $this->interpreter = $interpreter;
    }

    abstract public function getTokenInterpreters();
    
    protected function createUnary(callable $callback, $priority)
    {
        $interpreter = new TokenInterpreter\UnaryLeftInterpreter($this->interpreter, $callback, $priority);

        return $interpreter;
    }

    protected function createBinary(callable $callback, $priority, $rightPriority = null)
    {
        $interpreter = new TokenInterpreter\BinaryOperatorInterpreter($this->interpreter, $callback, $priority, $rightPriority);

        return $interpreter;
    }

    protected function createStringOrArrayDeclarator(callable $callback)
    {
        $interpreter = $this->createDeclarator(function ($string) use ($callback) {
            return $this->handleStringOrArray($callback, $string);
        });

        return $interpreter;
    }

    protected function createStringOrArrayDeclaratorWithParam(callable $callback)
    {
        $interpreter = $this->createDeclarator(function ($string, $parameter) use ($callback) {
            if (is_array($string)) {
                return array_map(function ($row) use ($callback, $parameter) {
                    return $callback($row, $parameter);
                }, $string);
            }

            return $callback($string, $parameter);
        });

        return $interpreter;
    }

    protected function createDeclarator(callable $callback)
    {
        $interpreter = new DeclaratorInterpreter($this->interpreter, $callback);
        $interpreter->setPriority(10);

        return $interpreter;
    }

    protected function handleStringOrArray(callable $callback, $string)
    {
        if (is_array($string)) {
            return array_map($callback, $string);
        }

        return $callback($string);
    }
}
