<?php

namespace Yarik\MicroSymfony\Component\Form;

class SimpleType implements FormTypeInterface
{
    protected $name = '';

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function build(FormBuilder $builder)
    {}

    public function getName()
    {
        return $this->name;
    }
}