<?php

namespace App\Main\Command;

use App\Main\Document\Doc;
use Yarik\MicroSymfony\Component\Console\ArgvInput;

class TestCommand extends BaseCommand
{
    public function execute(ArgvInput $input)
    {
        $time = microtime(true) * 1000;

        $manager = $this->container->getDocumentManager();
        $object = $manager->find(Doc::class, 12);
        var_dump($object);

        var_dump(microtime(true) * 1000 - $time);
    }

    public function getName()
    {
        return 'test';
    }
}