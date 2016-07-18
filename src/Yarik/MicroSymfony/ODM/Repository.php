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
        $this->class = $class;
    }

    public function find($id)
    {
        return $this->manager->find($this->class, $id);
    }

    public function findPrimeBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->findBy($criteria, $orderBy, $limit, $offset, true);
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $prime = false)
    {
        $objects = $this->getCollection()->find($criteria, $orderBy, $limit, $offset);
        $items = $this->manager->createMany($this->class, $objects, $prime);

        $map = [];
        foreach ($items as $item) {
            $this->manager->initializeObject($item);
            if (method_exists($item, '__setInited')) {
                $item->__setInited(true);
            }

            $map[$item->getId()] = $item;
        }

        return $map;
    }

    public function findAll()
    {
        return $this->findBy([]);
    }

    public function findOneBy(array $criteria, array $orderBy = [], $offset = null)
    {
        $data = $this->getCollection()->findOne($criteria, $orderBy, $offset);
        if (!$data) {
            return null;
        }

        $object = $this->manager->create($this->class, (array)$data);
        $this->manager->initializeObject($object, $data);

        if (method_exists($object, '__setInited')) {
            $object->__setInited(true);
        }

        return $object;
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
