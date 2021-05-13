<?php

interface Service
{
    public function execute(): string;
}

class ServiceImplementation implements Service
{
    public function execute(): string
    {
        return __METHOD__;
    }
}

class Proxy implements Service
{
    public function __construct(private ServiceImplementation $serviceImplementation)
    {
    }

    public function execute(): string
    {
        return $this->serviceImplementation->execute() . '<br>' . __METHOD__;
    }
}

/**
 * Client
 */

$serviceImplementation = new ServiceImplementation();

$proxy = new Proxy($serviceImplementation);

echo $proxy->execute();
