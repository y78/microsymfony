<?php

namespace Yarik\MicroSymfony\ODM;

use Yarik\MicroSymfony\ODM\Persistence\DocumentManager;

abstract class Document implements \Serializable
{
    abstract public function getId();

    /** @var DocumentManager $_dm */
    private $__dm;
    private $__isInit = true;

    protected function __init()
    {
        if ($this->__isInit) {
            return $this;
        }

        $this->__dm->find(static::class, $this->getId());
        $this->__isInit = true;
        return $this;
    }

    public function __setInited()
    {
        $this->__isInit = true;
    }

    public function __setDM(DocumentManager $dm)
    {
        $this->__dm = $dm;
        $this->__isInit = false;
        return $this;
    }

    public function serialize()
    {
        $r = new \ReflectionClass($this);
        $map = [];
        foreach ($r->getProperties() as $prop) {
            $name = $prop->getName();
            if ($name == '__dm' || $name == '__isInit') {
                continue;
            }

            $prop->setAccessible(true);
            $map[$name] = $prop->getValue($this);
        }

        return serialize($map);
    }

    public function unserialize($serialized)
    {
        $r = new \ReflectionClass($this);
        $map = unserialize($serialized);

        foreach ($map as $key => $value) {
            $prop = $r->getProperty($key);
            $prop->setAccessible(true);
            $prop->setValue($this, $value);
        }
    }
}
