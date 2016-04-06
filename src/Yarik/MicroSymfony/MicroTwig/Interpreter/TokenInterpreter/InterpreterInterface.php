<?php

namespace Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;

use Yarik\MicroSymfony\MicroTwig\Interpreter\TokenInterpreter;

interface InterpreterInterface
{
    public function getLeftPriority();

    public function getRightPriority();

    /**
     * Обрабатывает лексему и помещает в стек, если необходимо
     */
    public function handle(array $token);

    /**
     * Срабатывает после изъятия из стекаа
     * @return mixed
     */
    public function flush();
}
