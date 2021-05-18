<?php

interface Service
{
    public function make(): string;
}

class ServiceImplementation implements Service
{
    public function make(): string
    {
        return __METHOD__;
    }
}

interface Logger
{
    public function write(string $message): void;
}

class LoggerImplementation implements Logger
{
    public function write(string $message): void
    {
        echo 'Log: ' . $message . '<br>';
    }
}

class ActionClientUseCase
{
    public function __construct(private Service $service, private Logger $logger)
    {
    }

    public function execute(): string
    {
        $text = $this->service->make();

        $this->logger->write($text);

        return $text;
    }
}

/**
 **************************************************************************************************************
 * Mocking
 **************************************************************************************************************
 */
class StubService implements Service
{
    public function make(): string
    {
        return 'Test';
    }
}

interface Mock
{
    public function mockObjectMethodWasExecutedCorrectly(): bool;
}

class MockLogger implements Logger, Mock
{
    private bool $isExecuted = false;

    public function write(string $message): void
    {
        $this->setIsExecutedTrue();
    }

    private function setIsExecutedTrue(): void
    {
        $this->isExecuted = true;
    }

    public function mockObjectMethodWasExecutedCorrectly(): bool
    {
        return $this->isExecuted;
    }
}

class ActionClientUseCaseTest
{
    private MockLogger $logger;
    private ActionClientUseCase $actionClientUseCase;

    public function run(): void
    {
        $this->setUp();
        $this->test_succeed_client_action();
    }

    protected function setUp(): void
    {
        $service = new StubService();
        $this->logger = new MockLogger();

        $this->actionClientUseCase = new ActionClientUseCase($service, $this->logger);
    }

    protected function test_succeed_client_action(): void
    {
        $response = $this->actionClientUseCase->execute();

        $this->assertTrue($this->logger->mockObjectMethodWasExecutedCorrectly());

        $this->assertEquals('Test', $response);
    }

    protected function assertTrue(mixed $condition): void
    {
        $this->assertEquals(true, $condition);
    }

    protected function assertEquals(mixed $expected, mixed $actual): void
    {
        if ($expected === $actual) {
            echo '<p style="color: green;">OK</p>';
            return;
        }

        echo '<p style="color: red;">Error</p>';
    }
}

/**
 * Client
 *
 * $actionClientUseCase = new ActionClientUseCase(new ServiceImplementation(), new LoggerImplementation());
 * echo $actionClientUseCase->execute();
 */

$actionClientUseCaseTest = new ActionClientUseCaseTest();

$actionClientUseCaseTest->run();
