<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\Extension;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Handler\ArithmeticHandler;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Handler\LogicHandler;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Interpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\BinaryOperatorInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\BracketOpenInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\BracketCloseInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\PunctuationInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\UnaryLeftInterpreter;

class ArithmeticExtension extends Extension
{
    protected $arithmeticHandler;
    protected $logicHandler;

    public function __construct(Interpreter $interpreter)
    {
        parent::__construct($interpreter);

        $this->arithmeticHandler = new ArithmeticHandler();
        $this->logicHandler = new LogicHandler();
    }

    public function getTokenInterpreters()
    {
        $and = $this->createBinary([$this->logicHandler, 'andOperation'], 1);
        $or  = $this->createBinary([$this->logicHandler, 'orOperation'], 1);
        $not = $this->createUnary([$this->logicHandler, 'not'], 10);

        return [
            '|'  => $this->createBinary([$this->logicHandler, 'byteOr'], 5),

            '+' => $this->createBinary([$this->arithmeticHandler, 'sum'], 3),
            '-' => $this->createBinary([$this->arithmeticHandler, 'difference'], 3, 4),
            '*' => $this->createBinary([$this->arithmeticHandler, 'product'], 5),
            '/' => $this->createBinary([$this->arithmeticHandler, 'division'], 5),

            '(' => new BracketOpenInterpreter($this->interpreter),
            ')' => new BracketCloseInterpreter($this->interpreter),
            ',' => new PunctuationInterpreter($this->interpreter, function ($a) {return $a;}),

            '==' => $this->createBinary([$this->logicHandler, 'equals'], 2),
            '!=' => $this->createBinary([$this->logicHandler, 'notEquals'], 2),
            '>' => $this->createBinary([$this->logicHandler, 'more'], 2),
            '<' => $this->createBinary([$this->logicHandler, 'less'], 2),
            'and' => $and, '&&' => $and,
            'or' => $or, '||' => $or,
            'not' => $not, '!' => $not
        ];
    }
}
