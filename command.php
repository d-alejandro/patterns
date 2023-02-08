<?php

interface Command
{
    public function execute(): string;
}

class CommandA implements Command
{
    public function execute(): string
    {
        return __METHOD__;
    }
}

class CommandB implements Command
{
    public function execute(): string
    {
        return __METHOD__;
    }
}

class Invoker
{
    public function __construct(
        private Command $commandA,
        private Command $commandB
    ) {
    }

    public function executeCommandA(): string
    {
        return $this->commandA->execute();
    }

    public function executeCommandB(): string
    {
        return $this->commandB->execute();
    }
}

/**
 * Client
 */

$commandA = new CommandA();
$commandB = new CommandB();

$invoker = new Invoker($commandA, $commandB);

echo $invoker->executeCommandA() . '<br>' . $invoker->executeCommandB();
