<?php

interface State
{
    public function make(Context $context): string;
}

class Context
{
    private State $state;

    public function __construct()
    {
        $this->setStateImplementationA();
    }

    public function make(): string
    {
        return $this->state->make($this);
    }

    public function setStateImplementationA(): void
    {
        $this->state = new StateImplementationA();
    }

    public function setStateImplementationB(): void
    {
        $this->state = new StateImplementationB();
    }
}

class StateImplementationA implements State
{
    public function make(Context $context): string
    {
        $context->setStateImplementationB();

        return __METHOD__;
    }
}

class StateImplementationB implements State
{
    public function make(Context $context): string
    {
        $context->setStateImplementationA();

        return __METHOD__;
    }
}

/**
 * Client
 */

$context = new Context();

echo $context->make(), '<br>';
echo $context->make(), '<br>';
echo $context->make();
