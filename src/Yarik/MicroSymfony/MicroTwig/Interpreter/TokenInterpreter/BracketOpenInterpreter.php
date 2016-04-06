<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;


use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class BracketOpenInterpreter extends AbstractTokenInterpreter
{
    protected $priority = -1;

    public function handle(array $token)
    {
        $this->interpreter->getTokenStack()->push($this);
    }

    public function flush()
    {
        return ;
    }

    public function getTokenType()
    {
        return Lexer::TYPE_UNARY_OPERATOR;
    }
}