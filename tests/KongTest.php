<?php

class KongTest extends \PHPUnit\Framework\TestCase
{
    protected $kong;

    public function setUp() {
        $this->kong = new Kong(new HttpClient('http://localhost:8001'));
    }

    protected function runTest()
    {
        $exception = null;

        $this->startKong();

        try {
            $result = parent::runTest();
        } catch (Throwable $ex) {
            $exception = $ex;
        }

        $this->stopKong();

        if ($exception) {
            throw $exception;
        }

        return $result;
    }

    private function startKong()
    {
        if ($this->isContainerStarted()) {
            return;
        }

        try {
            $this->startDatabaseContainer();
            $this->runKongMigrations();
            $this->startKongContainer();
        } catch (Throwable $exception) {
            $this->stopKong();
            throw $exception;
        }
    }

    private function stopKong()
    {
        $output = [];
        $status = 0;

        exec('docker-compose down 2>/dev/null', $output, $status);
    }

    private function checkIfDockerComposeIsInstalled()
    {
        $output;
        $status = 0;
    
        exec('docker-compose version 2>/dev/null', $output, $status);

        if ($status !== 0) {
            throw new Exception('the `docker-compose` command is not installed or accisable from this user. Integration tests required docker to be run.');
        }
    }

    private function isContainerStarted()
    {
        $this->checkIfDockerComposeIsInstalled();

        exec('docker-compose ps 2>/dev/null', $output, $status);

        return count($output) === 4 && strpos(strtolower($output[2]), ' up ') && strpos(strtolower($output[3]), ' up ');
    }

    private function startDatabaseContainer()
    {
        exec('docker-compose up -d postgres 2>/dev/null', $output, $status);

        if ($status !== 0) {
            print_r($output);
            throw new Exception('Failed to start database.');
        }

        sleep(3); // Database needs some time to spin up after docker finishes.
    }

    private function runKongMigrations()
    {
        exec('docker-compose run --rm kong kong migrations up 2>/dev/null', $output, $status);

        if ($status !== 0) {
            print_r($output);
            throw new Exception('Failed to run migrations.');
        }
    }

    private function startKongContainer()
    {
        exec('docker-compose up -d kong 2>/dev/null', $output, $status);

        if ($status !== 0) {
            print_r($output);
            throw new Exception('Failed to run migrations.');
        }

        // Wait for kong to start
        sleep(2);
    }
}
