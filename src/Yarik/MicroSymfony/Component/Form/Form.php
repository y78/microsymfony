<?php

namespace Yarik\MicroSymfony\Component\Form;

use Yarik\MicroSymfony\Component\HttpFoundation\Request;

class Form
{
    protected $data = null;
    protected $name = 'form';
    protected $method;
    protected $mapping = [];
    protected $valid = false;

    public function __construct(array $mapping, $method = 'post', $data = null)
    {
        $this->mapping = $mapping;
        $this->method = $method;
        $this->data = $data;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function handleRequest(Request $request)
    {
        $data = strtolower($this->getMethod()) == 'get' ? $_GET : $_POST;
        if (empty($data)) {
            $this->valid = false;
            return $this;
        }

        $this->valid = true;
        foreach ($this->mapping[2] as $name => &$child) {
            if (isset($data[$name])) {
                $child[1]['value'] = $data[$name];
            } else {
                $this->valid = false;
            }
        }

        if (is_object($this->data)) {
            $this->fillObjectData($this->mapping, $this->data);
        }

        return $this;
    }

    public function fillObjectData(array &$form, &$data)
    {
        foreach ($form[2] as $key => $child) {
            if (isset($child[1]['value'])) {
                $data->{'set' . ucfirst($key)}($child[1]['value']);
            } else {
                $this->fillObjectData($child, $data->{'get' . ucfirst($key)}());
            }
        }
    }

    public function createView()
    {
        $view = new FormView($this->prepareRecursive($this->mapping));
        $view->setForm($this);

        return $view;
    }

    private function prepareRecursive(array $node, $name = null)
    {
        $children = [];
        foreach ($node[2] as $childName => $child) {
            $children[$childName] = $this->prepareRecursive($child, $name ? $name . '[' . $childName . ']' : $childName);
        }

        return array_merge([
            'widget' => is_string($node[0]) ? $node[0] : $node[0]->getName(),
            'name' => $name,
            'label' => $name,
            'children' => &$children
        ], $node[1]);
    }
}