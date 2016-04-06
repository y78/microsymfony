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

    public function __construct($name = 'form', FormTypeInterface $type = null, $data = null)
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
                    $this->currentDataNode = $dataNode->{'get' . ucfirst($key)}();
                } else {
                    $this->currentDataNode = null;
                }
            }

            if (null !== $this->currentDataNode && !is_object($this->currentDataNode) && !is_array($this->currentDataNode)) {
                $child[1]['value'] = $this->currentDataNode;
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

    public function toArray()
    {
        return $this->root;
    }
}