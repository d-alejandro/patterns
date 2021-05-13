<?php

interface Strategy
{
    public function process(int $x, int $y): int;
}

class Addition implements Strategy
{
    public function process(int $x, int $y): int
    {
        return $x + $y;
    }
}

class Subtraction implements Strategy
{
    public function process(int $x, int $y): int
    {
        return $x - $y;
    }
}

class Context
{
    public function __construct(private Strategy $strategy)
    {
    }

    public function execute(int $x, int $y): int
    {
        return $this->strategy->process($x, $y);
    }
}

/**
 * Client
 */

$context = new Context(new Addition());
echo $context->execute(3, 4);

echo '<br>';

$contextSubtraction = new Context(new Subtraction());
echo $contextSubtraction->execute(3, 4);
