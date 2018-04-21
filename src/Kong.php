<?php

namespace DouglasDC3\Kong;

use DouglasDC3\Kong\Api\Consumers;
use DouglasDC3\Kong\Api\Routes;
use DouglasDC3\Kong\Api\Services;
use DouglasDC3\Kong\Http\HttpClient;
use DouglasDC3\Kong\Model\Info;

class Kong
{
    /**
     * @var \DouglasDC3\Kong\Http\HttpClient
     */
    private $client;

    /**
     * Kong constructor.
     *
     * @param \DouglasDC3\Kong\Http\HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return \DouglasDC3\Kong\Model\Info
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function info()
    {
        return new Info($this->client->get(''));
    }

    /**
     * Consumers
     */
    public function consumers()
    {
        return new Consumers($this);
    }

    public function services()
    {
        return new Services($this);
    }

    public function routes()
    {
        return new Routes($this);
    }

    public function getClient()
    {
        return $this->client;
    }
}
