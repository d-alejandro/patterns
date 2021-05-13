<?php

/**
 * Interface Observer / Listener
 */
interface Observer
{
    public function update(): void;
}

class ObserverImplementationA implements Observer
{
    public function update(): void
    {
        echo '=^-^=' . '<br>';
    }
}

class ObserverImplementationB implements Observer
{
    public function update(): void
    {
        echo '>^_^<' . '<br>';
    }
}

class Subject
{
    private array $observers = [];

    public function registerObserver(Observer $observer): void
    {
        $this->observers[] = $observer;
    }

    public function execute(): string
    {
        $this->notifyObserver();

        return __METHOD__;
    }

    private function notifyObserver(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update();
        }
    }
}

/**
 * Client
 */

$subject = new Subject();

$observerImplementationA = new ObserverImplementationA();
$observerImplementationB = new ObserverImplementationB();

$subject->registerObserver($observerImplementationA);
$subject->registerObserver($observerImplementationB);

echo $subject->execute();
