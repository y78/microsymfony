<?php

namespace Yarik\MicroSymfony\ODM;

use Yarik\MicroSymfony\ODM\Persistence\Collection;
use Yarik\MicroSymfony\ODM\Persistence\DocumentManager;

class Repository implements ObjectRepository
{
    /** @var Collection */
    protected $collection;

    /** @var DocumentManager $manager */
    protected $manager;
    protected $class;

    public function __construct(DocumentManager $manager, $class)
    {
        $this->manager = $manager;
    }

    public function find($id)
    {
        return $this->manager->find($this->class, $id);
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->getCollection()->find($criteria, $orderBy, $limit, $offset);
    }

    public function findAll()
    {
        return $this->findBy([]);
    }

    public function findOneBy(array $criteria, array $orderBy = null, $offset = null)
    {
        return $this->collection->findOne($criteria, $orderBy, $offset);
    }

    public function getClassName()
    {
        return $this->class;
    }

    public function getCollection()
    {
        if ($this->collection) {
            return $this->collection;
        }

        return $this->collection = $this->manager->getCollection($this->getClassName());
    }
}
