<?php

namespace Yarik\MicroSymfony\Component\Parser;

class YamlParser
{
    const TYPE_KEY = 'key';
    const TYPE_ARRAY_ELEMENT_START = 'element_start';
    const TYPE_VALUE = 'value';
    const TYPE_EMPTY = 'empty';

    protected $spaces = [];
    protected $file;
    protected $type = null;
    protected $value = null;
    protected $level = -1;
    protected $line = '';

    protected function handleValue($value)
    {
        if ($value[0] === '{' || $value[0] === '[') {
            $value = preg_replace('/([{,]+)(\s*)([^"\']+?)\s*:/','$1"$3":', $value) . PHP_EOL;
            $value = preg_replace('/([{\:\,\[]++)\s*([^\[\\\'"\s,\]:\}]+)/', '$1"$2"', $value);
            $value = str_replace('\\', '\\\\', $value);

            return json_decode($value, true);
        }

        return $value;
    }

    public function read()
    {
        $stack = []; $len = 0;
        $tree = []; $current = &$tree;
        foreach ($this->parse() as $type) {
            while ($len > $this->level) {
                $current = &$stack[$len-1];
                unset($stack[--$len]);
            }

            if ($this->type === self::TYPE_VALUE) {
                $current = $this->handleValue($this->value);
            }

            if ($this->type === self::TYPE_ARRAY_ELEMENT_START) {
                if (is_null($current)) {
                    $current = [];
                }

                $stack[$len++] = &$current;
                $current[] = null;
                $current = &$current[count($current) - 1];
            }

            if ($this->type === self::TYPE_KEY && $len <= $this->level) {
                if (is_null($current)) {
                    $current = [];
                }

                $stack[$len++] = &$current;
                $current[$this->value] = null;
                $current = &$current[$this->value];
            }
        }

        return $tree;
    }

    protected function parse()
    {
        while (null !== $this->next()) {
            if ($this->line === '') {
                continue;
            }

            if ($this->line == '-') {
                $this->value = [];
                yield $this->type = self::TYPE_ARRAY_ELEMENT_START;
                continue;
            }

            if (preg_match('/^([\.\_\\\\\-\w]+)\:\s*(.*)$/', $this->line, $matches)) {
                $this->value = $matches[1];
                $this->type = self::TYPE_KEY;

                yield $this->type;

                if ('' !== $matches[2]) {
                    $this->level++;
                    $this->value = $matches[2];
                    yield $this->type = self::TYPE_VALUE;

                    $this->level--;
                }
                
                continue;
            }

            if (preg_match('/^-\s*(.*)/', $this->line, $matches)) {
                yield $this->type = self::TYPE_ARRAY_ELEMENT_START;
                $this->level++;

                $this->value = $matches[1];
                yield $this->type = self::TYPE_VALUE;
                $this->level--;
                continue;
            }

            $this->value = $this->line;
            yield $this->type = self::TYPE_VALUE;
        }
    }

    public function next()
    {
        if (false === $line = fgets($this->file)) {
            return null;
        }

        $line = preg_replace('/\#.*$/', '', $line);

        $line = rtrim($line);
        $this->line = ltrim($line);
        if ($this->line === '') {
            return true;
        }

        $spaces = strlen($line) - strlen($this->line);
        while ($this->spaces) {
            if ($spaces <= end($this->spaces)) {
                array_pop($this->spaces);
                $this->level--;

                continue;
            }

            break;
        }

        $this->level++;
        $this->spaces[] = $spaces;

        return true;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function close()
    {
        fclose($this->file);
    }

    public function open($path)
    {
        $this->file = fopen($path, 'r');
    }
}