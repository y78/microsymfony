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

    public function __construct(array $mapping, $method = 'post', $data = [])
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

    public function getData()
    {
        return $this->data;
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
                $child[1]['value'] = null;

                if (!isset($child[1]['required']) || $child[1]['required']) {
                    $this->valid = false;
                }
            }
        }

        if (is_array($this->data)) {
            $this->fillArrayData($this->mapping, $this->data);
        }

        if (is_object($this->data)) {
            $this->fillObjectData($this->mapping, $this->data);
        }

        return $this;
    }

    public function fillArrayData(array &$form, &$data)
    {
        foreach ($form[2] as $key => $child) {
            if (isset($child[1]['value'])) {
                $data[$key] = $this->prepareValue($child);
            } else {
                $this->fillArrayData($child, $data[$key]);
            }
        }
    }

    public function fillObjectData(array &$form, &$data)
    {
        foreach ($form[2] as $key => $child) {
            if (array_key_exists('value', $child[1])) {
                $data->{'set' . ucfirst($key)}($this->prepareValue($child));
            } else {
                $prefix = method_exists($data, 'get' . ucfirst($key)) ? 'get' : 'is';
                $this->fillObjectData($child, $data->{$prefix . ucfirst($key)}());
            }
        }
    }

    protected function prepareValue($data)
    {
        list($type, $vars) = $data;
        if (!isset($vars['value'])) {
            return null;
        }

        $value = $vars['value'];
        switch ($type) {
            case 'integer':
                return (int)$value;
            case 'choice':
                return $vars['choices'][$value];
            case 'checkbox':
                return (bool)$value;
            case 'array':
                $valueType = isset($vars['type']) ? $vars['type'] : 'text';
                
                return array_map(function ($value) use ($valueType) {
                    return $this->prepareValue([$valueType, ['value' => $value], []]);
                }, explode(',', $value));
        }

        return $value;
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