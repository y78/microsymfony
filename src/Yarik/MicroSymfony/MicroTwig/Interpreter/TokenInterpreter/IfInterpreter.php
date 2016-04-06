<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;


use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class IfInterpreter extends DeclaratorInterpreter
{
    protected $priority = 0;

    public function handle(array $token)
    {
        $this->interpreter->getTokenStack()->push($this);
    }

    public function flush()
    {
        if ($value = $this->interpreter->getValueStack()->pop()) {
            return;
        }

        while ($next = $this->interpreter->next()) {
            if (isset($next['type']) && in_array($next['type'], [Lexer::TYPE_ELSE, Lexer::TYPE_END])) {
                break;
            }
        }
    }

    public function getTokenType()
    {
        return Lexer::TYPE_UNARY_OPERATOR;
    }
}