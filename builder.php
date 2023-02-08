<?php

interface TextBuilder
{
    public function getText(): string;
}

interface StepABuilder extends TextBuilder
{
    public function buildStepA(): StepABuilder;
}

interface StepBBuilder extends TextBuilder
{
    public function buildStepB(): StepBBuilder;
}

interface Builder extends StepABuilder, StepBBuilder
{
}

class BuilderImplementation implements Builder
{
    private string $text = '';

    public function buildStepA(): StepABuilder
    {
        $this->setText(__METHOD__);

        return $this;
    }

    public function buildStepB(): StepBBuilder
    {
        $this->setText(__METHOD__);

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    private function setText(string $methodName): void
    {
        $this->text .= $methodName . '<br>';
    }
}

class Director
{
    public function __construct(
        private Builder $builder
    ) {
    }

    public function build(): string
    {
        return $this->builder
            ->buildStepA()
            ->buildStepB()
            ->getText();
    }
}

class Manager
{
    public function __construct(
        private StepABuilder $stepABuilder
    ) {
    }

    public function build(): string
    {
        return $this->stepABuilder
            ->buildStepA()
            ->getText();
    }
}

/**
 * Client
 */

$builder = new BuilderImplementation();
$director = new Director($builder);
echo $director->build();

$secondBuilder = new BuilderImplementation();
$manager = new Manager($secondBuilder);
echo $manager->build();
