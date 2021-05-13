<?php

interface Element
{
    public function accept(Visitor $visitor): string;
}

interface Visitor
{
    public function visitElementImplementationA(ElementImplementationA $element): string;

    public function visitElementImplementationB(ElementImplementationB $element): string;
}

class ElementImplementationA implements Element
{
    public function accept(Visitor $visitor): string
    {
        return $visitor->visitElementImplementationA($this);
    }
}

class ElementImplementationB implements Element
{
    public function accept(Visitor $visitor): string
    {
        return $visitor->visitElementImplementationB($this);
    }
}

class VisitorImplementationA implements Visitor
{
    public function visitElementImplementationA(ElementImplementationA $element): string
    {
        return __METHOD__;
    }

    public function visitElementImplementationB(ElementImplementationB $element): string
    {
        return __METHOD__;
    }
}

/**
 * Client
 */

$elementImplementationA = new ElementImplementationA();

$visitorImplementationA = new VisitorImplementationA();

echo $elementImplementationA->accept($visitorImplementationA);

echo '<br>';

$elementImplementationB = new ElementImplementationB();

echo $elementImplementationB->accept($visitorImplementationA);
