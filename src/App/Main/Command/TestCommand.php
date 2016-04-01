<?php

namespace App\Main\Command;

use App\Main\Document\Doc;
use Yarik\MicroSymfony\Component\Cache\CacheSaver;
use Yarik\MicroSymfony\Component\Console\ArgvInput;

class TestCommand extends BaseCommand
{
    public function execute(ArgvInput $input)
    {
//        $time = microtime(true) * 1000;
//        $doc = $this->container->getDocumentManager()->find(Doc::class, 2);
//        var_dump($doc);
//        var_dump(microtime(true) * 1000 - $time);
//        die;

        /** @var CacheSaver $saver */
        $saver = $this->container->get('cache.saver');
        $saver->save();
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