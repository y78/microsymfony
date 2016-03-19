<?php

namespace Yarik\MicroSymfony\Component\Parser;

class YamlParser
{
    protected $current;
    protected $tree;
    protected $lines;
    protected $level;

    public function __construct()
    {
    }

    public function parse($data)
    {
        preg_match_all('/([\ \t]*)(.+?)\n/', $data, $matches);
        $this->lines = [];
        for ($i = 0; $i < count(reset($matches)); $i++) {
            $this->lines[] = [strlen($matches[1][$i]), $matches[2][$i]];
        }

        $this->tree = [];
        $this->level = -1;
        $this->handle($this->tree);
        var_dump($this->tree);
    }

    protected function handle(&$node)
    {
        list ($level, $key) = $this->getline();

        if ($this->level >= $level) {
            return ;
        }

        while ($this->level < $level) {
            $this->handle($node[$key]);
        }
    }

    protected function getline()
    {
        return array_shift($this->lines);
    }
}