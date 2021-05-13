<?php

interface ProductFactory
{
    public function make(string $name): Product;
}

interface Product
{
    public function getMethodName(): string;
}

class ProductFactoryImplementation implements ProductFactory
{
    /**
     * @throws Exception
     */
    public function make(string $name): Product
    {
        return match ($name) {
            ProductA::class => new ProductA(),
            ProductB::class => new ProductB(),
            default => throw new Exception('Wrong product name!'),
        };
    }
}

class ProductA implements Product
{
    public function getMethodName(): string
    {
        return __METHOD__;
    }
}

class ProductB implements Product
{
    public function getMethodName(): string
    {
        return __METHOD__;
    }
}

/**
 * Client
 */

$factory = new ProductFactoryImplementation();

$productA = $factory->make(ProductA::class);

$productB = $factory->make(ProductB::class);

echo $productA->getMethodName(), '<br>', $productB->getMethodName();
