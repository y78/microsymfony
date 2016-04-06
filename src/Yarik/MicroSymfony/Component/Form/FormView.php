<?php

namespace Yarik\MicroSymfony\Component\Form;

class FormView implements \ArrayAccess, \Countable, \Iterator
{
    protected $theme;
    protected $base;

    protected $widgets;
    protected $data;
    protected $form;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->base = __DIR__ . '/../../Resources/view/form_base_templates.php';
    }

    public function init()
    {
        if (!$this->widgets) {
            $this->widgets = require($this->base);
        }

        if ($this->theme) {
            $this->widgets = array_merge($this->widgets, require($this->theme));
        }

        return $this;
    }

    public function widget($data, $params = [])
    {
        if (!$this->widgets) {
            $this->init();
        }

        return $this->widgets[$data['widget']](array_merge_recursive($data, $params), $this);
    }

    public function formStart()
    {
        echo(sprintf('<form name="%s" method="%s">', $this->form->getName(), $this->form->getMethod()));
    }

    public function formEnd()
    {
        echo('</form>');
    }

    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    public function setForm(Form $form)
    {
        $this->form = $form;
        return $this;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data['children']);
    }

    public function offsetGet($offset)
    {
        return $this->data['children'][$offset];
    }

    public function offsetSet($offset, $value)
    {
        if (null === $offset) {
            $this->data['children'][] = $value;
        } else {
            $this->data['children'][$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->data['children'][$offset]);
    }

    public function rewind()
    {
        return reset($this->data['children']);
    }

    public function current()
    {
        return current($this->data['children']);
    }

    public function key()
    {
        return key($this->data['children']);
    }

    public function next()
    {
        next($this->data['children']);
    }

    public function valid()
    {
        return key($this->data['children']) !== null;
    }

    public function count()
    {
        return count($this->data['children']);
    }
}