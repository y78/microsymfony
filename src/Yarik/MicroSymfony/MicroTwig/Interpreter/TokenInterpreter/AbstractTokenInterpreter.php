<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;

use Yarik\MicroSymfony\MicroTwig\Interpreter\Interpreter;

abstract class AbstractTokenInterpreter implements InterpreterInterface
{
    protected $argumentsErrorMessage = 'Недостаточно параметров';

    abstract public function getTokenType();

    protected $leftPriority = 0;
    protected $rightPriority = 0;

    protected $interpreter;
    protected $callback;

    public function __construct(Interpreter $interpreter, $callback = null, $leftPriority = null, $rightPriority = null)
    {
        $this->interpreter = $interpreter;
        $this->callback = $callback;

        if (null !== $leftPriority) {
            $this->leftPriority = $leftPriority;

            if (null === $rightPriority) {
                $this->rightPriority = $this->leftPriority;
            }
        }

        if (null !== $rightPriority) {
            $this->rightPriority = $rightPriority;
        }
    }

    /**
     * По умолчанию выполняем callback, в который передаются параметры из стека
     * И помещаем в стек со значениями результат
     */
    public function flush()
    {
        $arguments = $this->interpreter->getValueStack()->splice($this->getArgumentsCount());
        if ($this->getArgumentsCount() > count($arguments)) {
            throw new \Exception($this->argumentsErrorMessage);
        }

        $value = call_user_func_array($this->callback, $arguments);

        if (null !== $value) {
            $this->interpreter->getValueStack()->push($value);
        }
    }

    /**
     * По умолчанию используется стандартный алгоритм обработки для операторов
     * Выполняем интерпретаторы из стека с приоритетом более текущего
     * Помещаем в стек текущий интерпретатор
     */
    public function handle(array $token)
    {
        $stack = $this->interpreter->getTokenStack();

        while ($token = $stack->end()) {
            if ($token->getRightPriority() <= $this->getLeftPriority()) {
                break;
            }

            $stack->pop()->flush();
        }

        $stack->push($this);
    }

    public function setCallback(callable $callback)
    {
        $this->callback = $callback;
        return $this;
    }

    public function getArgumentsCount()
    {
        return 2;
    }

    public function getLeftPriority()
    {
        return $this->leftPriority;
    }

    public function getRightPriority()
    {
        return $this->rightPriority;
    }

    public function setLeftPriority($priority)
    {
        $this->leftPriority = $priority;
        return $this;
    }

    public function setRightPriority($priority)
    {
        $this->rightPriority = $priority;
        return $this;
    }

    public function setPriority($priority)
    {
        $this->leftPriority = $this->rightPriority = $priority;
        return $this;
    }
}