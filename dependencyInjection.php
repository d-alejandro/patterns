<?php

class Client
{
    public function __construct(private ServiceA $serviceA, private ServiceB $serviceB)
    {
    }

    public function execute(): string
    {
        return $this->serviceA->make() . '<br>' . $this->serviceB->build();
    }
}

interface ServiceA
{
    public function make(): string;
}

class ServiceAImplementation implements ServiceA
{
    public function make(): string
    {
        return __METHOD__;
    }
}

interface ServiceB
{
    public function build(): string;
}

class ServiceBImplementation implements ServiceB
{
    public function build(): string
    {
        return __METHOD__;
    }
}

class Provider
{
    private array $bindings = [
        ServiceA::class => ServiceAImplementation::class,
        ServiceB::class => ServiceBImplementation::class,
    ];

    public function getBindings(): array
    {
        return $this->bindings;
    }
}

class Injector
{
    private array $bindings;

    private ReflectionClass $reflectionClass;
    private array $arguments;

    /**
     * @throws ReflectionException
     */
    public function createObject(string $class): object
    {
        $this->init($class);

        $this->prepareArguments();

        return $this->createInstance();
    }

    /**
     * @throws ReflectionException
     */
    private function init(string $class): void
    {
        $provider = new Provider();

        $this->bindings = $provider->getBindings();

        $this->reflectionClass = new ReflectionClass($class);
    }

    private function prepareArguments(): void
    {
        $constructor = $this->reflectionClass->getConstructor();

        $params = $constructor->getParameters();

        foreach ($params as $param) {
            $this->createArgument($param);
        }
    }

    private function createArgument(ReflectionParameter $param): void
    {
        $interfaceName = $param->getType()->getName();

        $className = $this->findClassByInterface($interfaceName);

        $this->arguments[] = new $className;
    }

    private function findClassByInterface($interfaceName): string
    {
        return $this->bindings[$interfaceName];
    }

    /**
     * @throws ReflectionException
     */
    private function createInstance(): object
    {
        return $this->reflectionClass->newInstanceArgs($this->arguments);
    }
}

/**
 * Client
 */

$injector = new Injector();

try {
    $client = $injector->createObject(Client::class);

    echo $client->execute();
} catch (ReflectionException) {
}
