<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\Extension;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Handler\StringHandler;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Interpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;
use App\Util\StringUtil;

class DeclaratorExtension extends Extension
{
    public function __construct(Interpreter $interpreter)
    {
        parent::__construct($interpreter);
    }

    public function getTokenInterpreters()
    {
        $interpreters = [
            '.' => new TokenInterpreter\DotInterpreter($this->interpreter, null, 20, 30),
        ];

        return $interpreters;
    }
}
