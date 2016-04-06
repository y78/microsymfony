<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\Struct;

class Stack
{
    protected $array;

    public function __construct(array $array = [])
    {
        $this->array = $array;
    }

    public function clear()
    {
        $this->array = [];
    }

    public function count()
    {
        return count($this->array);
    }

    public function splice($count)
    {
        if (!$count) {
            return [];
        }

        return array_splice($this->array, -$count);
    }

    public function push($value)
    {
        array_push($this->array, $value);

        return $this;
    }

    public function pop()
    {
        return array_pop($this->array);
    }

    public function end()
    {
        return end($this->array);
    }

    public function toArray()
    {
        return $this->array;
    }
}
