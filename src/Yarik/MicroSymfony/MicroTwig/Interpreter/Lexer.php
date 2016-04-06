<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter;

class Lexer extends AbstractLexer
{
    const TYPE_CONSTANT = 0;
    const TYPE_DECLARATOR = 1;
    const TYPE_BINARY_OPERATOR = 2;
    const TYPE_UNARY_OPERATOR = 3;
    const TYPE_PUNCTUATION = 4;
    const TYPE_END = 5;
    const TYPE_IF = 6;
    const TYPE_ELSE = 7;

    protected $types = [];

    public function addToken($alias, $type)
    {
        $this->types[$alias] = $type;
        return $this;
    }

    public function getCatchablePatterns()
    {
        uksort($this->types, function ($a, $b) {
            return strlen($b) - strlen($a);
        });

        return array_merge([
            '[\@а-яa-z_\\\][а-яa-z0-9_\:\\\]*[а-яa-z0-9_]{1}',
            '(?:[0-9]+(?:[\.][0-9]+)*)(?:e[+-]?[0-9]+)?',
            '\'(?:[^\']|\'\')*\'',
            '"(?:[^"]|"")*"',
            '\?[0-9]*|:[а-яa-z]{1}[a-z0-9_]{0,}'
        ], array_map(function ($item) {
            return str_replace('/', '\/', preg_quote($item));
        }, array_keys($this->types)));
    }

    public function next()
    {
        if ($this->moveNext()) {
            return $this->lookahead;
        }

        return null;
    }

    /** Добавлен модификатор u для поддержки русских символов */
    protected function scan($input)
    {
        static $regex;

        if ( ! isset($regex)) {
            $regex = '/('
                . implode(')|(', $this->getCatchablePatterns()) . ')|'
                . implode('|', $this->getNonCatchablePatterns()) . '/ui'
            ;
        }

        $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE;
        $matches = preg_split($regex, $input, -1, $flags);

        foreach ($matches as $match) {
            $type = $this->getType($match[0]);

            $this->tokens[] = array(
                'value' => $match[0],
                'type'  => $type,
                'position' => $match[1],
            );
        }
    }

    protected function getNonCatchablePatterns()
    {
        return ['\s+', '(.)'];
    }

    protected function getType(&$value)
    {
        if (isset($this->types[$value])) {
            return $this->types[$value];
        }

        if (is_numeric($value) || $value[0] == '\'' || $value[0] == '"') {
            return self::TYPE_CONSTANT;
        }

        return self::TYPE_CONSTANT;
    }
}
