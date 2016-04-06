<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\Extension;

use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\ElseInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\EndIfInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\IfInterpreter;

class ConditionExtension extends Extension
{
    public function getTokenInterpreters()
    {
        $if = new IfInterpreter($this->interpreter);
        $else = new ElseInterpreter($this->interpreter);
        $endif = new EndIfInterpreter($this->interpreter);

        return [
            'if' => $if,
            'else' => $else,
            'end' => $endif,
            ':' => $else,
            ';' => $endif
        ];
    }
}
