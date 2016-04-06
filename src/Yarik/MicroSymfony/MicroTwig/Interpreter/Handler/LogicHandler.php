<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\Handler;

class LogicHandler
{
    public function notEquals($left, $right)
    {
        return $left != $right;
    }

    public function equals($left, $right)
    {
        return $left == $right;
    }

    public function byteOr($left, $right)
    {
        return $left | $right;
    }

    public function more($a, $b)
    {
        return $a > $b;
    }

    public function less($a, $b)
    {
        return $a < $b;
    }

    public function not($value)
    {
        return !$value;
    }

    public function orOperation($left, $right)
    {
        return $left || $right;
    }

    public function andOperation($left, $right)
    {
        return $left && $right;
    }
}
