<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter;

/**
 * @fixme скопирован из Doctrine для замены private методов и свойств на protected
 */
abstract class AbstractLexer
{
    protected $tokens = array();

    protected $position = 0;

    protected $peek = 0;

    public $lookahead;

    public $token;

    public function setInput($input)
    {
        $this->tokens = array();
        $this->reset();
        $this->scan($input);
    }

    public function reset()
    {
        $this->lookahead = null;
        $this->token = null;
        $this->peek = 0;
        $this->position = 0;
    }

    public function resetPeek()
    {
        $this->peek = 0;
    }

    public function resetPosition($position = 0)
    {
        $this->position = $position;
    }

    public function isNextToken($token)
    {
        return null !== $this->lookahead && $this->lookahead['type'] === $token;
    }

    public function isNextTokenAny(array $tokens)
    {
        return null !== $this->lookahead && in_array($this->lookahead['type'], $tokens, true);
    }

    public function moveNext()
    {
        $this->peek = 0;
        $this->token = $this->lookahead;
        $this->lookahead = (isset($this->tokens[$this->position]))
            ? $this->tokens[$this->position++] : null;

        return $this->lookahead !== null;
    }

    public function skipUntil($type)
    {
        while ($this->lookahead !== null && $this->lookahead['type'] !== $type) {
            $this->moveNext();
        }
    }

    public function isA($value, $token)
    {
        return $this->getType($value) === $token;
    }

    public function peek()
    {
        if (isset($this->tokens[$this->position + $this->peek])) {
            return $this->tokens[$this->position + $this->peek++];
        } else {
            return null;
        }
    }

    public function glimpse()
    {
        $peek = $this->peek();
        $this->peek = 0;
        return $peek;
    }

    protected function scan($input)
    {
        static $regex;

        if ( ! isset($regex)) {
            $regex = '/(' . implode(')|(', $this->getCatchablePatterns()) . ')|'
                . implode('|', $this->getNonCatchablePatterns()) . '/i';
        }

        $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE;
        $matches = preg_split($regex, $input, -1, $flags);

        foreach ($matches as $match) {
            // Must remain before 'value' assignment since it can change content
            $type = $this->getType($match[0]);

            $this->tokens[] = array(
                'value' => $match[0],
                'type'  => $type,
                'position' => $match[1],
            );
        }
    }

    public function getLiteral($token)
    {
        $className = get_class($this);
        $reflClass = new \ReflectionClass($className);
        $constants = $reflClass->getConstants();

        foreach ($constants as $name => $value) {
            if ($value === $token) {
                return $className . '::' . $name;
            }
        }

        return $token;
    }

    abstract protected function getCatchablePatterns();

    abstract protected function getNonCatchablePatterns();

    abstract protected function getType(&$value);
}
