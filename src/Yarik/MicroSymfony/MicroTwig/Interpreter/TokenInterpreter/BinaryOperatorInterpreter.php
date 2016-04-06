<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class BinaryOperatorInterpreter extends AbstractTokenInterpreter
{
    public function getTokenType()
    {
        return Lexer::TYPE_BINARY_OPERATOR;
    }
}