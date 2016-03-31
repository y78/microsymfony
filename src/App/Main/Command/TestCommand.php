<?php

namespace App\Main\Command;

use App\Main\Document\Doc;
use Yarik\MicroSymfony\Component\Console\ArgvInput;

class TestCommand extends BaseCommand
{
    public function execute(ArgvInput $input)
    {
        $time = microtime(true) * 1000;
        for ($i = 0; $i < 40000000; $i++) {
            $doc = new Doc();
            $this->test($doc);
        }

        var_dump(microtime(true) * 1000 - $time);
    }

    public function test(Doc $doc)
    {
        return $doc;
    }

    public function getName()
    {
        return 'test';
    }
}