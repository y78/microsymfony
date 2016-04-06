<?php

namespace Yarik\MicroSymfony\ODM\Persistence;

use Yarik\MicroSymfony\ODM\Repository;

class DocumentManager implements ObjectManager
{
    /** @var \MongoDB $db */
    protected $db;
    protected $idsCollection;
    protected $client;
    protected $metadata = [];

    protected $persist = [];
    protected $hydrators = [];
    protected $collections = [];
    protected $repositories = [];

    protected $original = [];
    protected $objects = [];

    public function __construct(\MongoDB\Driver\Manager $client, $dbName, array $metadata)
    {
        $this->client = $client;
        $this->db = $dbName;
        $this->metadata = $metadata;

        $this->idsCollection = new Collection($this->client, $this->db, 'microids');
    }

    public function getRepository($class)
    {
        return $this->repositories[$class] =
            $this-$this->repositories[$class] ??
            new Repository($this, $class)
        ;
    }

    /** @return Collection */
    public function getCollection($class)
    {
        if (isset($this->collections[$class])) {
            return $this->collections[$class];
        }

        $collectionName = $this->metadata[$class]['collection'];
        return $this->collections[$class] = new Collection($this->client, $this->db, $collectionName);
    }

    public function find($class, $id)
    {
        if (null === $data = $this->getCollection($class)->findOne(['_id' => $id])) {
            return null;
        }

        $object = $this->create($class, (array)$data);
        $this->initializeObject($object, $data);

        return $object;
    }

    public function persist($object)
    {
        $this->objects[get_class($object)][spl_object_hash($object)] = $object;

        return $this;
    }

    public function getHydrator($class)
    {
        if (!$hydrator = &$this->hydrators[$class]) {
            return $this->hydrators[$class] = new Hydrator($this, $class, $this->metadata[$class]['mapping']);
        }

        return $hydrator;
    }

    public function create($class, array $data)
    {
        return $this->getHydrator($class)->hydrate($data);
    }

    public function initializeObject($object, $data = [])
    {
        $id = spl_object_hash($object);
        $data = $this->getHydrator($class = get_class($object))->unhydrate($object);

        $this->original[$class][$id] = $data;
        $this->objects[$class][$id] = $object;

        return $this;
    }

    public function flush()
    {
        foreach ($this->objects as $class => $objects) {
            $collection = $this->getCollection($class);

            foreach ($objects as $id => $object) {
                $data = $this->getHydrator($class)->unhydrate($object);

                if (isset($this->original[$class][$id]) && serialize($this->original[$class][$id]) == serialize($data)) {
                    continue;
                }

                if (!isset($data['_id'])) {
                    $lastId = isset($lastId) ? ++$lastId : $this->getLastId($class);
                    $data['_id'] = $lastId;

                    $r = new \ReflectionProperty($class, 'id');
                    $r->setAccessible(true);
                    $r->setValue($object, $lastId);

                    unset($r);
                }

                $collection->upsert($data);
            }

            if (isset($lastId)) {
                $this->setLastId($class, $lastId);
            }

            $collection->flush();
        }

        return $this;
    }

    public function remove($object)
    {
        // TODO: Implement remove() method.
    }

    public function merge($object)
    {
        // TODO: Implement merge() method.
    }

    public function clear($objectName = null)
    {
        // TODO: Implement clear() method.
    }

    public function detach($object)
    {
        // TODO: Implement detach() method.
    }

    public function refresh($object)
    {
        // TODO: Implement refresh() method.
    }

    public function contains($object)
    {
        return isset($this->original[get_class($object)][spl_object_hash($object)]);
    }

    protected function prepareFields($class, $fields)
    {
        foreach ($fields as &$field) {
            if (isset($this->metadata[$class][$field]['name'])) {
                if ($field === '_id') {
                    $field = '_id';
                }

                $field = $this->metadata[$class][$field]['name'];
            }
        }

        if ($fields && !in_array('_id', $fields)) {
            $fields[] = '_id';
        }

        return $fields;
    }

    protected function setLastId($class, $id)
    {
        $this
            ->idsCollection
            ->upsert(['_id' => $class, 'val' => $id])
            ->flush()
        ;

        return $this;
    }

    protected function getLastId($class)
    {
        if (null === $data = $this->idsCollection->findOne(['_id' => $class])) {
            return 1;
        }

        return $data['val'] + 1;
    }
}
