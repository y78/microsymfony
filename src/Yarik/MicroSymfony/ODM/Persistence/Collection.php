<?php

namespace Yarik\MicroSymfony\ODM\Persistence;

use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Query;

class Collection
{
    /** @var BulkWrite */
    protected $bulkWrite;
    protected $manager;
    protected $namespace;

    public function __construct(\MongoDB\Driver\Manager $manager, $dbName, $collectionName)
    {
        $this->manager = $manager;
        $this->namespace = $dbName . '.' . $collectionName;
        $this->bulk();
    }

    public function bulk()
    {
        unset($this->bulkWrite);

        $this->bulkWrite = new BulkWrite();
        return $this;
    }

    public function upsert(array $newObj, array $options = [])
    {
        return $this->update(
            ['_id' => $newObj['_id']],
            $newObj,
            $options + ['upsert' => true]
        );
    }

    public function update(array $criteria, $newObj, array $options = [])
    {
        $this->bulkWrite->update($criteria, $newObj, $options);
        return $this;
    }

    public function flush()
    {
        if (!$this->bulkWrite->count()) {
            return null;
        }

        $result = $this->manager->executeBulkWrite($this->namespace, $this->bulkWrite);
        $this->bulk();
        return $result;
    }

    public function find(array $criteria = null, array $sort = null, $limit = null, $skip = null)
    {
        $params = [];
        if ($sort)  $params['sort'] = $sort;
        if ($limit) $params['limit'] = $limit;
        if ($skip)  $params['skip'] = $skip;

        return $this->manager->executeQuery($this->namespace, $query = new Query($criteria, $params))->toArray();
    }

    public function findOne(array $criteria = [], array $sort = [], $skip = null)
    {
        $result = $this->find($criteria, $sort, 1, $skip);

        if (!$result) {
            return null;
        }

        return (array)reset($result);
    }
}
