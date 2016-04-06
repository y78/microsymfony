<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;

class ValueInterpreter extends AbstractTokenInterpreter
{
    protected $constants = [];
    protected $context = null;

    public function handle(array $token)
    {
        $value = $token['value'];

        $lastToken = $this->interpreter->getTokenStack()->end();
        if ($lastToken instanceof DotInterpreter) {
            $this->interpreter->getValueStack()->push($value);
            return;
        }

        if (isset($this->constants[$value])) {
            $this->interpreter->getValueStack()->push($this->constants[$value]);
            return;
        }

        if (null !== $contextValue = $this->getKeyFromContext($value)) {
            $value = $contextValue;
        }

        if (is_string($value) && isset($value[0]) && in_array($value[0], ['\'', '"'])) {
            $value = substr($value, 1, -1);
        }

        $this->interpreter->getValueStack()->push($value);
    }

    public function hasConstant($key)
    {
        return isset($this->constants[$key]) || null !== $contextValue = $this->getKeyFromContext($key);
    }

    public function getKeyFromContext($key)
    {
        if (isset($this->context[$key])) {
            return $this->context[$key];
        }

        if (is_object($this->context)) {
            if (method_exists($this->context, $key)) {
                return $this->context->{$key}();
            }

            if (method_exists($this->context, 'get' . ucfirst($key))) {
                return $this->context->{'get' . ucfirst($key)}();
            }

            if (method_exists($this->context, 'is' . ucfirst($key))) {
                return $this->context->{'is' . ucfirst($key)}();
            }

            if (property_exists($this->context, $key)) {
                return $this->context->{$key};
            }
        }

        return null;
    }

    public function addConstant($alias, $value)
    {
        $this->constants[$alias] = $value;
        return $this;
    }

    public function clearConstants()
    {
        $this->constants = [];
    }

    public function setConstants(array $constants)
    {
        $this->constants = $constants;
        return $this;
    }

    public function setContext($context)
    {
        $this->context = $context;
        return $this;
    }

    public function getTokenType()
    {
        return Lexer::TYPE_CONSTANT;
    }
}