<?php

namespace Yarik\MicroSymfony\Component\HttpFoundation;

class ParameterBag implements \Iterator
{
    protected $data = [];

    public function __construct(array $data = null)
    {
        if ($data) {
            $this->data = $data;
        }
    }

    public function has($key)
    {
        return isset($this->data[$key]);
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function getInt($key, $default = null)
    {
        if (null === $result = $this->get($key, $default)) {
            return null;
        }

        return (int)$result;
    }

    public function getFloat($key, $default = null)
    {
        if (null === $result = $this->get($key, $default)) {
            return null;
        }

        return (float)$this->get($key, $default);
    }

    public function get($key, $default = null)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return $default;
    }

    public function all()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function current()
    {
        return current($this->data);
    }

    public function next()
    {
        return next($this->data);
    }

    public function key()
    {
        return key($this->data);
    }

    public function valid()
    {
        return current($this->data);
    }

    public function rewind()
    {
        return reset($this->data);
    }

}