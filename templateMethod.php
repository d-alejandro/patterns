<?php

abstract class AbstractClass
{
    abstract protected function methodA(): string;

    abstract protected function methodB(): string;

    final public function methodC(): string
    {
        return $this->methodA() . '<br>' . $this->methodB();
    }
}

class AbstractClassExtension extends AbstractClass
{
    protected function methodA(): string
    {
        return __METHOD__;
    }

    protected function methodB(): string
    {
        return __METHOD__;
    }
}

/**
 * Client
 */

$abstractClassExtension = new AbstractClassExtension();

echo $abstractClassExtension->methodC();
