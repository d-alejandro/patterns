<?php

interface Component
{
    public function execute(): string;
}

class Сomposite implements Component
{
    private array $componentList = [];

    public function add(Component $component): void
    {
        $this->componentList[] = $component;
    }

    public function execute(): string
    {
        $string = '';

        foreach ($this->componentList as $component) {
            $string .= $component->execute() . '<br>';
        }

        return $string;
    }
}

class ComponentA implements Component
{
    public function execute(): string
    {
        return __METHOD__;
    }
}

class ComponentB implements Component
{
    public function execute(): string
    {
        return __METHOD__;
    }
}

/**
 * Client
 */

$componentA = new ComponentA();
$componentB = new ComponentB();

$composite = new Сomposite();

$composite->add($componentA);
$composite->add($componentB);

echo $composite->execute();
