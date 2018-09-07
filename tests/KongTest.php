<?php

use DouglasDC3\Kong\Kong;
use DouglasDC3\Kong\Http\HttpClient;

class KongTest extends \PHPUnit\Framework\TestCase
{
    const DELAY_START = 4;
    /** @var Kong */
    protected $kong;

    public function setUp()
    {
        $this->kong = new Kong(new HttpClient('http://localhost:8001'));
    }

    public static function setUpBeforeClass()
    {
        static::startKong();
    }

    public static function tearDownAfterClass()
    {
        static::stopKong();
    }

    private static function startKong()
    {
        if (static::isContainerStarted()) {
            return;
        }

        try {
            static::startDatabaseContainer();
            static::runKongMigrations();
            static::startKongContainer();
        } catch (Throwable $exception) {
            static::stopKong();
            throw $exception;
        }
    }

    private static function stopKong()
    {
        $output = [];
        $status = 0;

        exec('docker-compose down 2>/dev/null', $output, $status);
    }

    private static function checkIfDockerComposeIsInstalled()
    {
        $output = null;
        $status = 0;

        exec('docker-compose version 2>/dev/null', $output, $status);

        if ($status !== 0) {
            throw new Exception('the `docker-compose` command is not installed or accisable from this user. Integration tests required docker to be run.');
        }
    }

    private static function isContainerStarted()
    {
        static::checkIfDockerComposeIsInstalled();

        exec('docker-compose ps 2>/dev/null', $output, $status);

        return count($output) === 4 && strpos(strtolower($output[2]), ' up ') && strpos(strtolower($output[3]), ' up ');
    }

    private static function startDatabaseContainer()
    {
        exec('docker-compose up -d postgres 2>/dev/null', $output, $status);

        if ($status !== 0) {
            print_r($output);
            throw new Exception('Failed to start database.');
        }

        sleep(self::DELAY_START); // Database needs some time to spin up after docker finishes.
    }

    private static function runKongMigrations()
    {
        exec('docker-compose run --rm kong kong migrations up 2>/dev/null', $output, $status);

        if ($status !== 0) {
            print_r($output);
            throw new Exception('Failed to run migrations.');
        }
    }

    private static function startKongContainer()
    {
        exec('docker-compose up -d kong 2>/dev/null', $output, $status);

        if ($status !== 0) {
            print_r($output);
            throw new Exception('Failed to run migrations.');
        }

        // Wait for kong to start
        sleep(self::DELAY_START);
    }
}
