<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class PunctuationInterpreter extends AbstractTokenInterpreter
{
    public function handle(array $token)
    {
    }

    public function getTokenType()
    {
        return Lexer::TYPE_PUNCTUATION;
    }
}