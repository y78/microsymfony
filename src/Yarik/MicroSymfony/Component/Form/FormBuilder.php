<?php

namespace Yarik\MicroSymfony\Component\Form;

class FormBuilder
{
    protected $name;
    protected $method = 'post';
    protected $data;
    protected $root;
    protected $currentNode;
    protected $currentDataNode;

    public function __construct($name = 'form', FormTypeInterface $type = null, $data = [])
    {
        if (null === $type) {
            $type = new FormType();
        }

        $this->name = $name;
        $this->data = $data;
        $this->root = [$type, [], []];

        $this->currentNode = &$this->root[2];
        $this->currentDataNode = $data;
        $type->build($this);
    }

    public function add($name, $type = 'text', $parameters = [])
    {
        $this->currentNode[$name] = [$type, $parameters, []];

        return $this;
    }

    public function setMethod($method = 'post')
    {
        $this->method = $method;

        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getForm()
    {
        $this->buildRecursive($this->root);

        return new Form($this->root, $this->method, $this->data);
    }

    private function buildRecursive(array &$node)
    {
        $dataNode = $this->currentDataNode;
        foreach ($node[2] as $key => &$child) {
            $this->currentNode = &$child[2];

            if ($dataNode) {
                if (is_array($dataNode) && isset($dataNode[$key])) {
                    $this->currentDataNode = $dataNode[$key];
                } elseif (is_object($dataNode)) {
                    $prefix = method_exists($dataNode, 'get' . ucfirst($key)) ? 'get' : 'is';
                    $this->currentDataNode = $dataNode->{$prefix . ucfirst($key)}();
                } else {
                    $this->currentDataNode = null;
                }
            }

            if (null !== $this->currentDataNode && !($child[0] instanceof FormTypeInterface)) {
                $child[1]['value'] = $this->prepareValue($this->currentDataNode, $child);
            }

            if ($this->currentNode) {
                continue;
            }

            $type = $child[0];
            if ($type instanceof FormTypeInterface) {
                $type->build($this);
            }

            $this->buildRecursive($child);
        }

        $this->currentNode = &$node[2];
        $this->currentDataNode = $dataNode;
    }

    protected function prepareValue($value, $node)
    {
        list ($type, $vars) = $node;
        if ($type == 'choice') {
            foreach ($vars['choices'] as $key => $choiceValue) {
                if ($choiceValue == $value) {
                    return $key;
                }
            }
        }
        return $value;
    }

    public function toArray()
    {
        return $this->root;
    }
}