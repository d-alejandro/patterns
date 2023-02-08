<?php

interface Mediator
{
    public function handle(Component $component): string;
}

abstract class Component
{
    private Mediator $mediator;

    public function setMediator(Mediator $mediator): void
    {
        $this->mediator = $mediator;
    }

    public function make(): string
    {
        return $this->mediator->handle($this);
    }

    abstract public function execute(): string;
}

class ComponentA extends Component
{
    public function execute(): string
    {
        return __METHOD__;
    }
}

class ComponentB extends Component
{
    public function execute(): string
    {
        return __METHOD__;
    }
}

class MediatorImplementation implements Mediator
{
    public function __construct(
        private ComponentA $componentA,
        private ComponentB $componentB
    ) {
        $this->componentA->setMediator($this);
        $this->componentB->setMediator($this);
    }

    public function handle(Component $component): string
    {
        if ($component instanceof ComponentA) {
            return $this->componentB->execute();
        } elseif ($component instanceof ComponentB) {
            return $this->componentA->execute();
        }

        return '';
    }
}

/**
 * Client
 */

$componentA = new ComponentA();
$componentB = new ComponentB();

$mediatorImplementation = new MediatorImplementation($componentA, $componentB);

echo $componentA->make();
