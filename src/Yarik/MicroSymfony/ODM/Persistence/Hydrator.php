<?php

namespace Yarik\MicroSymfony\ODM\Persistence;

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

    public function hydrate($data)
    {
        $object = $this->r->newInstanceWithoutConstructor();
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
                return $this
                    ->manager
                    ->create($options['targetDocument'], $data ? (array)$data : $data)
                ;
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
            case 'embed':
                return $this
                    ->manager
                    ->getHydrator($options['targetDocument'])
                    ->unhydrate($data)
                ;
        }

        return $data;
    }
}
