<?php

namespace DouglasDC3\Kong;

use DouglasDC3\Kong\Api\Consumers;
use DouglasDC3\Kong\Api\Plugins;
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
     * Interact with consumers API.
     *
     * @return \DouglasDC3\Kong\Api\Consumers
     */
    public function consumers()
    {
        return new Consumers($this);
    }

    /**
     * Interact with the Services API
     *
     * @return \DouglasDC3\Kong\Api\Services
     */
    public function services()
    {
        return new Services($this);
    }

    /**
     * Interact with the Routes API
     *
     * @return \DouglasDC3\Kong\Api\Routes
     */
    public function routes()
    {
        return new Routes($this);
    }

    /**
     * Interact with Plugins API.
     *
     * @return \DouglasDC3\Kong\Api\Plugins
     */
    public function plugins()
    {
        return new Plugins($this);
    }

    /**
     * Get HTTP Client.
     *
     * @return \DouglasDC3\Kong\Http\HttpClient
     */
    public function getClient()
    {
        return $this->client;
    }
}
