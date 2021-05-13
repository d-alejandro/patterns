<?php

interface Handler
{
    public function setNext(Handler $handler): Handler;

    public function handle(): string;
}

abstract class AbstractHandler implements Handler
{
    private Handler $nextHandler;

    public function setNext(Handler $handler): Handler
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle(): string
    {
        $string = $this->make() . '<br>';

        if (isset($this->nextHandler)) {
            $string .= $this->nextHandler->handle();
        }

        return $string;
    }

    abstract protected function make(): string;
}

class AbstractHandlerA extends AbstractHandler
{
    protected function make(): string
    {
        return __METHOD__;
    }
}

class AbstractHandlerB extends AbstractHandler
{
    protected function make(): string
    {
        return __METHOD__;
    }
}

class AbstractHandlerC extends AbstractHandler
{
    protected function make(): string
    {
        return __METHOD__;
    }
}

/**
 * Client
 */

$abstractHandlerA = new AbstractHandlerA();
$abstractHandlerB = new AbstractHandlerB();
$abstractHandlerC = new AbstractHandlerC();

$abstractHandlerA
    ->setNext($abstractHandlerB)
    ->setNext($abstractHandlerC);

echo $abstractHandlerA->handle();
