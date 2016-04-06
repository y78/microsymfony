<?php

namespace Yarik\Microsymfony\Command;

use Yarik\MicroSymfony\Component\Cache\CacheSaver;
use Yarik\MicroSymfony\Component\Console\ArgvInput;
use Yarik\MicroSymfony\Component\Console\BaseCommand;

class CacheUpdateCommand extends BaseCommand
{
    public function execute(ArgvInput $input)
    {
        /** @var CacheSaver $saver */
        $saver = $this->container->get('cache.saver');
        $saver->save();
    }

    public function getName()
    {
        return 'cache:update';
    }
}