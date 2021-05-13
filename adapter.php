<?php

class APIClass
{
    public function make(): string
    {
        return __METHOD__;
    }
}

interface Adapter
{
    public function execute(): string;
}

class AdapterImplementation implements Adapter
{
    public function __construct(private APIClass $apiClass)
    {
    }

    public function execute(): string
    {
        return $this->apiClass->make();
    }
}

/**
 * Client
 */

$apiClass = new APIClass();

$adapterImplementation = new AdapterImplementation($apiClass);

echo $adapterImplementation->execute();
