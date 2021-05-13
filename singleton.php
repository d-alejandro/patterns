<?php

final class Singleton
{
    private static Singleton $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new \Exception('Cannot unserialize a singleton.');
    }

    public static function getInstance(): Singleton
    {
        self::$instance ??= new Singleton();

        return self::$instance;
    }

    public function getClassName(): string
    {
        return self::class;
    }
}

/**
 * Client
 */

$singleton = Singleton::getInstance();

echo $singleton->getClassName();
