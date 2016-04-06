<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;


use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class BracketCloseInterpreter extends AbstractTokenInterpreter
{
    protected $priority = 100;

    public function handle(array $token)
    {
        while ($token = $this->interpreter->getTokenStack()->pop()) {
            if ($token instanceof BracketOpenInterpreter) {
                break;
            }

            $token->flush();
        }

        if ($token = $this->interpreter->getTokenStack()->end()) {
            $this->interpreter->getTokenStack()->pop()->flush();
        }
    }

    public function getTokenType()
    {
        return Lexer::TYPE_UNARY_OPERATOR;
    }
}