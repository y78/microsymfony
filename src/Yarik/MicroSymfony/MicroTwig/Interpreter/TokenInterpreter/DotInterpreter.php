<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;


use Yarik\MicroSymfony\MicroTwig\Interpreter\Lexer;
use Doctrine\Common\Collections\ArrayCollection;

class DotInterpreter extends BinaryOperatorInterpreter
{
    protected $priority = 1000;

    public function handle(array $token)
    {
        $lexer = $this->interpreter->getLexer();
        $valueStack = $this->interpreter->getValueStack();

        $right = $lexer->peek();

        if ($this->interpreter->hasToken($right)) {
            return;
        }

        $value = $valueStack->pop();

        if ($right['type'] === Lexer::TYPE_CONSTANT) {
            $valueStack->pop();
            $value = $this->getValue($value, $right['value']);

            $valueStack->push($value);
            $this->interpreter->next();
        }
    }

    public function flush()
    {
        if ($this->interpreter->getValueStack()->count() < $this->getArgumentsCount()) {
            return;
        }

        $arguments = $this->interpreter->getValueStack()->splice($this->getArgumentsCount());
        $value = call_user_func_array([$this, 'callback'], $arguments);

        if (null !== $value) {
            $this->interpreter->getValueStack()->push($value);
        }
    }

    protected function getValue($target, $key)
    {
        if (is_array($target) || $target instanceof \ArrayAccess) {
            if (!isset($target[$key])) {
                return null;
            }

            return $target[$key];
        }

        if (!is_object($target)) {
            return null;
        }

        if (method_exists($target, 'get' . ucfirst($key))) {
            return $target->{'get' . ucfirst($key)}();
        }

        if (method_exists($target, 'is' . ucfirst($key))) {
            return $target->{'is' . ucfirst($key)}();
        }

        if (property_exists($target, $key)) {
            return $target->{$key};
        }

        return null;
    }

    public function getTokenType()
    {
        return Lexer::TYPE_BINARY_OPERATOR;
    }
}