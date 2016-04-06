<?php

namespace App\Main\Command;

use Yarik\MicroSymfony\Component\Console\ArgvInput;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Extension\ArithmeticExtension;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Extension\ConditionExtension;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Extension\DeclaratorExtension;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Interpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\ValueInterpreter;

class TestCommand extends BaseCommand
{
    protected $map = [];

    public function execute(ArgvInput $input)
    {
    }

    public function getName()
    {
        return 'test';
    }
}