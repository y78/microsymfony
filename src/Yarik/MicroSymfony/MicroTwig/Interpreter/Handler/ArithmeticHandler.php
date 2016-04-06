<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\Handler;

class ArithmeticHandler
{
    public function sum($left, $right)
    {
        if (!is_numeric($left) || !is_numeric($right)) {
            if (is_array($left) && !is_array($right)) {
                return array_map(function ($left) use ($right) {
                    return $this->sum($left, $right);
                }, $left);
            }

            if (is_array($right) && !is_array($left)) {
                return array_map(function ($right) use ($left) {
                    return $this->sum($left, $right);
                }, $right);
            }

            if (is_array($left) && is_array($right)) {
                $result = [];
                foreach ($left as $leftVal) {
                    foreach ($right as $rightVal) {
                        $result[] = $this->sum($leftVal, $rightVal);
                    }
                }

                return $result;
            }

            return $left . $right;
        }

        return $left + $right;
    }

    public function difference($left, $right)
    {
        if (!is_numeric($left) || !is_numeric($right)) {
            return preg_replace('/' . preg_quote((string)$right) . '/xui', '', (string)$left);
        }

        return $left - $right;
    }

    public function product($left, $right)
    {
        if (!is_numeric($left) || !is_numeric($right)) {
            if (is_array($left) && !is_array($right)) {
                return array_map(function ($left) use ($right) {
                    return $left . $right;
                }, $left);
            }

            if (is_array($right) && !is_array($left)) {
                return array_map(function ($right) use ($left) {
                    return $left . $right;
                }, $right);
            }

            return [$left, $right];
        }

        return $left * $right;
    }

    public function division($left, $right)
    {
        return $left / $right;
    }
}
