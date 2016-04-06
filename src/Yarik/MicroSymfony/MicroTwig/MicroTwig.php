<?php

namespace Yarik\MicroSymfony\MicroTwig;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Extension\ArithmeticExtension;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Extension\ConditionExtension;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Extension\DeclaratorExtension;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Interpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\ValueInterpreter;

class MicroTwig
{
    /** @var Interpreter */
    protected $interpreter;

    /** @var ValueInterpreter $valueInterpreter */
    protected $valueInterpreter;

    public function __construct()
    {
        $this->interpreter = $interpreter = new Interpreter(new Lexer());
        $this->valueInterpreter = new ValueInterpreter($interpreter);
        $interpreter
            ->addTokenInterpreter(Lexer::TYPE_CONSTANT, $this->valueInterpreter)
            ->addExtension(new ArithmeticExtension($interpreter))
            ->addExtension(new DeclaratorExtension($interpreter))
            ->addExtension(new ConditionExtension($interpreter))
        ;
    }

    public function render($file, $parameters = [])
    {
        return $this->getResult(file_get_contents($file), $parameters);
    }

    public function getResult($text, $context = [])
    {
        $this->valueInterpreter->setContext($context);
        $array = $this->splitText('  ' . $text . '  ');

        $result = [];
        foreach ($array as $index => $value) {
            if ($index % 2) {
                $value = $this->interpreter->handle($value);
            }

            $result[] = $value;
        }

        return trim(implode($result));
    }

    protected function splitText($text)
    {
        $text = preg_replace('/\s+/xui', ' ', $text);
        $pattern = '/\{\{(?:.*?)\}\}/xui';
        $left = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);
        preg_match_all($pattern, $text, $right);
        $right = reset($right);

        $result = [];
        for ($i = 0; $i < count($right); $i++) {
            $result[] = $left[$i];
            $result[] = trim(mb_substr($right[$i], 2, -2, 'UTF-8'));
        }

        $result[] = end($left);
        return $result;
    }
}