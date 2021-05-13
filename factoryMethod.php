<?php

interface EntityFactory
{
    public function make(): Entity;
}

interface Entity
{
    public function getMethodName(): string;
}

class EntityAFactory implements EntityFactory
{
    public function make(): Entity
    {
        return new EntityA();
    }
}

class EntityA implements Entity
{
    public function getMethodName(): string
    {
        return __METHOD__;
    }
}

/**
 * Client
 */

$entityAFactory = new EntityAFactory();

$entityA = $entityAFactory->make();

echo $entityA->getMethodName();
