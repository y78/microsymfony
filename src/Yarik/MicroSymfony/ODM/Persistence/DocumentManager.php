<?php

namespace Yarik\MicroSymfony\ODM\Persistence;

class DocumentManager implements ObjectManager
{
    /** @var \MongoDB $db */
    protected $db;
    protected $client;
    protected $metadata = [];

    protected $persist = [];
    protected $hydrators = [];
    protected $collections = [];

    protected $original = [];
    protected $objects = [];

    public function __construct(\MongoClient $client, $dbName, array $metadata)
    {
        $this->client = $client;
        $this->db = $client->selectDB($dbName);
        $this->metadata = $metadata;
    }

    /** @return \MongoCollection */
    public function getCollection($class)
    {
        if (isset($this->collections[$class])) {
            return $this->collections[$class];
        }

        $collectionName = $this->metadata[$class]['collection'];
        return $this->collections[$class] = $this->db->{$collectionName};
    }

    public function find($class, $id, $fields = [])
    {
        $fields = $this->prepareFields($class, $fields);
        if (null === $data = $this->getCollection($class)->findOne(['_id' => $id], $fields)) {
            return null;
        }

        $object = $this->create($class, $data);
        $this->initializeObject($object, $data);

        return $object;
    }

    public function persist($object)
    {
        $this->objects[get_class($object)][spl_object_hash($object)] = $object;

//        $class = get_class($object);
//        $prop = new \ReflectionProperty($class, 'id');
//        $prop->setAccessible(true);
//        $id = $this->getLastId($class);
//
//        if (null === $newId = $prop->getValue($object)) {
//            $prop->setValue($object, $id);
//            $newId = $id;
//        }
//
//        if ($id <= $newId) {
//            $this->setLastId($class, $newId+1);
//        }
//
//        $data = $this->getHydrator($class)->unhydrate($object);
//        $this->getCollection($class)->insert($data);
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
            $persist = [];

            foreach ($objects as $id => $object) {
                $data = $this->getHydrator($class)->unhydrate($object);

                if (!isset($this->original[$class][$id])) {
                    $persist[$id] = $data;
                    continue;
                }

                if (serialize($this->original[$class][$id]) == serialize($data)) {
                    continue;
                }

                $persist[$id] = $data;
            }

            foreach ($persist as $insertData) {
                if (!isset($insertData['_id'])) {
                    $insertData['_id'] = $id = $this->getLastId($class);
                    $this->setLastId($class, $id);
                }

                $id = $insertData['_id'];
                $this
                    ->getCollection($class)
                    ->update(['_id' => $id], $insertData, ['upsert' => true])
                ;
            }
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

    public function getRepository($className)
    {
        // TODO: Implement getRepository() method.
    }

    public function contains($object)
    {
        return isset($this->original[get_class($object)][spl_object_hash($object)]);
    }

    protected function prepareFields($class, $fields)
    {
        foreach ($fields as &$field) {
            if (isset($this->metadata[$class][$field]['name'])) {
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
        $this->db->microids->update(['_id' => $class], ['_id' => $class, 'val' => $id], ['upsert' => true]);
        return $this;
    }

    protected function getLastId($class)
    {
        if (null === $data = $this->db->microids->findOne(['_id' => $class])) {
            return 1;
        }

        return $data['val'] + 1;
    }
}
