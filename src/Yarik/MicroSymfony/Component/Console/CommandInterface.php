<?php

namespace Yarik\MicroSymfony\Component\Console;

interface CommandInterface
{
    public function getName();

    public function execute(ArgvInput $input);
}