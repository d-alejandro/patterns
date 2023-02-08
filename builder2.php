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

class TextBuilderImplementation implements TextBuilder
{
    public function __construct(
        protected TextDTO $textDTO
    ) {
    }

    public function getText(): string
    {
        return $this->textDTO->getText();
    }
}

final class TextDTO
{
    private string $text = '';

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $methodName): void
    {
        $this->text .= $methodName . '<br>';
    }
}

class StepABuilderImplementation extends TextBuilderImplementation implements StepABuilder
{
    public function buildStepA(): StepABuilder
    {
        $this->textDTO->setText(__METHOD__);

        return $this;
    }
}

class StepBBuilderImplementation extends TextBuilderImplementation implements StepBBuilder
{
    public function buildStepB(): StepBBuilder
    {
        $this->textDTO->setText(__METHOD__);

        return $this;
    }
}

class BuilderImplementation implements Builder
{
    private TextBuilder $textBuilder;

    public function __construct(
        private StepABuilder $stepABuilder,
        private StepBBuilder $stepBBuilder
    ) {
        $this->textBuilder = $stepABuilder;
    }

    public function buildStepA(): StepABuilder
    {
        $this->stepABuilder->buildStepA();

        return $this;
    }

    public function buildStepB(): StepBBuilder
    {
        $this->stepBBuilder->buildStepB();

        return $this;
    }

    public function getText(): string
    {
        return $this->textBuilder->getText();
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

$textDTO = new TextDTO();
$builder = new BuilderImplementation(
    new StepABuilderImplementation($textDTO),
    new StepBBuilderImplementation($textDTO)
);
$director = new Director($builder);
echo $director->build();


$secondTextDTO = new TextDTO();
$secondBuilder = new BuilderImplementation(
    new StepABuilderImplementation($secondTextDTO),
    new StepBBuilderImplementation($secondTextDTO)
);
$manager = new Manager($secondBuilder);
echo $manager->build();
