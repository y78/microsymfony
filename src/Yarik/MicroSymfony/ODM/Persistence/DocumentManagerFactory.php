<?php

namespace Yarik\MicroSymfony\ODM\Persistence;

use Yarik\MicroSymfony\Component\Parser\YamlReader;

class DocumentManagerFactory
{
    protected $configPath;
    protected $config = [];

    public function createDocumentManager(\MongoDB\Driver\Manager $client, $dbName)
    {
        $dm = new DocumentManager($client, $dbName, $this->config);

        return $dm;
    }

    public function __construct(YamlReader $reader, $configPath)
    {
        $this->config = $reader->read($configPath);
    }
}
