<?php

interface InterfaceA
{
    public function make(): string;
}

class SubsystemA implements InterfaceA
{
    public function make(): string
    {
        return __METHOD__;
    }
}

interface InterfaceB
{
    public function process(): string;
}

class SubsystemB implements InterfaceB
{
    public function process(): string
    {
        return __METHOD__;
    }
}

class Facade
{
    public function __construct(private InterfaceA $interfaceA, private InterfaceB $interfaceB)
    {
    }

    public function execute(): string
    {
        return $this->interfaceA->make() . '<br>' . $this->interfaceB->process();
    }
}

/**
 * Client
 */

$subsystemA = new SubsystemA();
$subsystemB = new SubsystemB();

$facade = new Facade($subsystemA, $subsystemB);

echo $facade->execute();
