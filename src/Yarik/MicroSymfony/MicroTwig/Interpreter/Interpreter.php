<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Extension\Extension;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\AbstractTokenInterpreter;
use Yarik\MicroSymfony\MicroTwig\Interpreter\Struct\Stack;
use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter\ValueInterpreter;

class Interpreter
{
    protected $lexer;
    protected $interpreters = [];
    protected $completions = [];

    protected $lastToken;
    protected $tokenStack;
    protected $valueStack;
    protected $concatenationHandler;

    public function __construct(Lexer $lexer)
    {
        $this->lexer = $lexer;

        $this->tokenStack = new Stack();
        $this->valueStack = new Stack();
    }

    public function handle($input)
    {
        $this->getTokenStack()->clear();
        $this->getValueStack()->clear();

        $this->lastToken = null;
        $this->lexer->setInput($input);

        while ($data = $this->lexer->next()) {
            // берём следующую лексему и обрабатываем её с помощью сопоставленного интерпретатора
            $current = $this->getTokenInterpreter($data);
            $current->handle($data);

            $this->lastToken = $data;
        }

        while ($interpreter = $this->tokenStack->pop()) {
            $interpreter->flush();
        }

        $result = '';
        while ($value = $this->valueStack->pop()) {
            if (is_array($value)) {
                $value = implode($value);
            }
            
            $result .= $value;
        }

        return $result;
    }

    public function addExtension(Extension $extension)
    {
        foreach ($extension->getTokenInterpreters() as $alias => $interpreter)  {
            $this->addTokenInterpreter($alias, $interpreter);
        }

        return $this;
    }

    public function addTokenInterpreter($alias, AbstractTokenInterpreter $interpreter)
    {
        $this->lexer->addToken($alias, $interpreter->getTokenType());
        $this->interpreters[$alias] = $interpreter;

        return $this;
    }

    public function getTokenStack()
    {
        return $this->tokenStack;
    }

    public function getValueStack()
    {
        return $this->valueStack;
    }

    public function getInterpreter($key)
    {
        if (!isset($this->interpreters[$key])) {
            return null;
        }

        return $this->interpreters[$key];
    }

    public function last()
    {
        return $this->lastToken;
    }

    public function getLexer()
    {
        return $this->lexer;
    }

    public function next()
    {
        return $this->lexer->next();
    }

    public function hasToken($data)
    {
        if (is_numeric($data['value'])) {
            return false;
        }

        if ($data['type'] == 0) {
            return false;
        }

        return isset($this->interpreters[$data['type']]) || isset($this->interpreters[$data['value']]);
    }

    /**
     * @return AbstractTokenInterpreter|null
     */
    protected function getTokenInterpreter($data)
    {
        if (isset($this->interpreters[$data['type']])) {
            return $this->interpreters[$data['type']];
        }

        return $this->interpreters[$data['value']];
    }
}
