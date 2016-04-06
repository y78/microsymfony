<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;


use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class ElseInterpreter extends AbstractTokenInterpreter
{
    protected $priority = -1;

    public function handle(array $token)
    {
        while ($next = $this->interpreter->next()) {
            if (isset($next['type']) && in_array($next['type'], [Lexer::TYPE_ELSE, Lexer::TYPE_END])) {
                break;
            }
        }
    }

    public function flush()
    {
    }

    public function getTokenType()
    {
        return Lexer::TYPE_ELSE;
    }
}