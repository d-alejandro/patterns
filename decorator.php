<?php

interface Component
{
    public function execute(): string;
}

class ComponentA implements Component
{
    public function execute(): string
    {
        return __METHOD__;
    }
}

class ComponentADecorator implements Component
{
    public function __construct(private Component $component)
    {
    }

    public function execute(): string
    {
        return $this->component->execute() . '<br>' . __METHOD__;
    }
}

/**
 * Client
 */

$componentA = new ComponentA();

$componentADecorator = new ComponentADecorator($componentA);

echo $componentADecorator->execute();
