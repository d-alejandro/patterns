<?php

class Builder
{
    private string $text = '';

    public function buildStepA(string $param): void
    {
        $this->setText(__METHOD__, $param);
    }

    public function buildStepB(string $param): void
    {
        $this->setText(__METHOD__, $param);
    }

    public function getText(): string
    {
        return $this->text;
    }

    private function setText(string $methodName, string $param): void
    {
        $this->text .= $methodName . ' with ' . $param . '<br>';
    }
}

interface CriterionInterface
{
    public function apply(Builder $builder): void;
}

class FirstCriterion implements CriterionInterface
{
    public function __construct(
        private string $param
    ) {
    }

    public function apply(Builder $builder): void
    {
        $builder->buildStepA($this->param);
    }
}

class SecondCriterion implements CriterionInterface
{
    public function __construct(
        private string $param
    ) {
    }

    public function apply(Builder $builder): void
    {
        $builder->buildStepB($this->param);
    }
}

class CriteriaApplier
{
    private array $criteria = [];

    public function __construct(
        private Builder $builder
    ) {
    }

    public function addCriterion(CriterionInterface $criterion): void
    {
        $this->criteria[] = $criterion;
    }

    public function applyCriteriaAndGetText(): string
    {
        foreach ($this->criteria as $criterion) {
            $criterion->apply($this->builder);
        }

        return $this->builder->getText();
    }
}

class Repository
{
    public function __construct(
        private CriteriaApplier $criteriaApplier
    ) {
    }

    public function make(): string
    {
        $this->criteriaApplier->addCriterion(new FirstCriterion('paramA'));
        $this->criteriaApplier->addCriterion(new SecondCriterion('paramB'));
        $this->criteriaApplier->addCriterion(new FirstCriterion('paramC'));

        return $this->criteriaApplier->applyCriteriaAndGetText();
    }
}

/**
 * Client
 */

$builder = new Builder();
$criteriaApplier = new CriteriaApplier($builder);
$repository = new Repository($criteriaApplier);

echo $repository->make();
