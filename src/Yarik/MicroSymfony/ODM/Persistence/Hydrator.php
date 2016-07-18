<?php

namespace Yarik\MicroSymfony\ODM\Persistence;

use Yarik\MicroSymfony\ODM\Document;

class Hydrator
{
    protected $r;
    protected $class;
    protected $mapping;

    /** @var DocumentManager $manager */
    protected $manager;

    public function __construct(DocumentManager $manager, $class, array $mapping)
    {
        $this->class = $class;
        $this->manager = $manager;
        $this->mapping = $mapping;
        $this->r = new \ReflectionClass($class);
    }

    public function unhydrate($object)
    {
        $r = new \ReflectionObject($object);
        $data = [];

        foreach ($this->mapping as $field => $options) {
            $name = isset($options['name']) ? $options['name'] : $field;

            if (!$r->hasProperty($field)) {
                continue;
            }

            $prop = $r->getProperty($field);
            $prop->setAccessible(true);

            if (null !== $value = $this->unhydrateValue($prop->getValue($object), $options)) {
                $data[$name] = $value;
            }
        }

        return $data;
    }

    public function hydrateMany(array $rows, $prime = false)
    {
        $items = array_map(function ($row) {
            return $this->hydrate((array)$row);
        }, $rows);


        if (!$prime) {
            return $items;
        }

        foreach ($this->mapping as $field => $options) {
            if ($options['type'] !== 'one' && $options['type'] !== 'many') {
                continue;
            }

            $map = [];
            $name = isset($options['name']) ? $options['name'] : $field;

            foreach ($items as $item) {
                $r = new \ReflectionObject($item);
                $prop = $r->getProperty($name);
                $prop->setAccessible(true);
                $sub = $prop->getValue($item);
                if (is_array($sub)) {
                    foreach ($sub as $subItem) {
                        $map[$subItem->getId()] = true;
                    }
                } else {
                    $map[$sub->getId()] = true;
                }
            }

            if (!$ids = array_keys($map)) {
                continue;
            }

            $subs = $this->manager->getRepository($options['target'])->findBy(['_id' => ['$in' => $ids]]);
        }

        return $items;
    }

    public function hydrate($data)
    {
        $init = isset($data['_id']);
        if (!$object = $this->manager->get($this->class, isset($data['_id']) ? $data['_id'] : null)) {
            $object = $this->r->newInstanceWithoutConstructor();
            if ($object instanceof Document) {
                $object->__setDM($this->manager);
            }
        } else {
        }

        $r = new \ReflectionObject($object);

        foreach ($this->mapping as $field => $options) {
            $name = isset($options['name']) ? $options['name'] : $field;
            if (!isset($data[$name])) {
                continue;
            }

            if (!$r->hasProperty($field)) {
                continue;
            }

            $prop = $r->getProperty($field);
            $prop->setAccessible(true);
            $value = $this->createValue($data[$name], $options);
            $prop->setValue($object, $value);
        }

        if ($init) {
            $this->manager->initializeObject($object);
        }

        return $object;
    }

    public function createValue($data, $options)
    {
        if (null === $data) {
            return null;
        }

        switch ($options['type']) {
            case 'int':     return (int)$data;
            case 'double':  return (double)$data;
            case 'boolean': return (boolean)$data;
            case 'string':  return (string)$data;
            case 'array':   return (array)$data;
            case 'embed':
                if (!$data) {
                    return $data;
                }

                if (isset($options['many']) && $options['many']) {
                    return array_map(function ($data) use ($options) {
                        return $this
                            ->manager
                            ->create($options['target'], $data ? (array)$data : $data)
                        ;
                    }, $data);
                }

                return $this
                    ->manager
                    ->create($options['target'], $data ? (array)$data : $data)
                ;
            case 'many':
                if (!$data = (array)$data) {
                    return $data;
                }

                return array_map(function ($id) use ($options) {
                    return $this->manager->create($options['target'], ['_id' => (int)$id]);
                }, $data);
            case 'one':
                if (null === $data) {
                    return null;
                }

                return $this->manager->create($options['target'], ['_id' => (int)$data]);
            case 'date':
                return new \DateTime($data->date);
        }

        return $data;
    }

    protected function unhydrateValue($data, $options)
    {
        if (null === $data) {
            return null;
        }

        switch ($options['type']) {
            case 'int':     return (int)$data;
            case 'double':  return (double)$data;
            case 'boolean': return (boolean)$data;
            case 'string':  return (string)$data;
            case 'array':   return (array)$data;
            case 'one':
                return $data ? (int)$data->getId() : null;
            case 'many':
                return $data ? array_map(function ($item) {
                    return (int)$item->getId();
                }, $data) : $data;
            case 'embed':
                if (isset($options['many']) && $options['many']) {
                    return array_map(function ($data) use ($options) {
                        return $this
                            ->manager
                            ->getHydrator($options['target'])
                            ->unhydrate($data)
                        ;
                    }, $data);
                }

                return $this
                    ->manager
                    ->getHydrator($options['target'])
                    ->unhydrate($data)
                ;
        }

        return $data;
    }
}
