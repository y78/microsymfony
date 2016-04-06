<?php

namespace Yarik\MicroSymfony\Component\Form;

class FormType implements FormTypeInterface
{
    public function build(FormBuilder $builder)
    {
    }

    public function getName()
    {
        return 'form';
    }
}