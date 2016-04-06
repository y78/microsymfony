<?php

namespace Yarik\MicroSymfony\Component\Form;

interface FormTypeInterface
{
    public function build(FormBuilder $builder);

    public function getName();
}