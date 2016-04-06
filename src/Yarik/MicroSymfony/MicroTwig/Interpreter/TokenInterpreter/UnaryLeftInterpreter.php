<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;


use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class UnaryLeftInterpreter extends AbstractTokenInterpreter
{
    protected $priority = 0;

    public function handle(array $token)
    {
        $this->interpreter->getTokenStack()->push($this);
    }

    public function getTokenType()
    {
        return Lexer::TYPE_UNARY_OPERATOR;
    }

    public function getArgumentsCount()
    {
        return 1;
    }
}