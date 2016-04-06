<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;


use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class DeclaratorInterpreter extends AbstractTokenInterpreter
{
    protected $priority = 1000;

    public function handle(array $token)
    {
        $stack = $this->interpreter->getTokenStack();
        if ($stack->end() instanceof DotInterpreter) {
            $stack->pop();
        }

        $this->interpreter->getTokenStack()->push($this);
    }

    public function getTokenType()
    {
        return Lexer::TYPE_DECLARATOR;
    }

    public function getArgumentsCount()
    {
        if (is_array($this->callback)) {
            $method = new \ReflectionMethod($this->callback[0], $this->callback[1]);
            return $method->getNumberOfParameters();
        }

        $function = new \ReflectionFunction($this->callback);
        return $function->getNumberOfParameters();
    }
}