<?php

namespace DouglasDC3\Kong\Api\Plugin;

use DouglasDC3\Kong\Api\KongApi;

class KeyAuth extends KongApi
{
    /**
     * @var \DouglasDC3\Kong\Model\Consumer
     */
    private $consumer;

    /**
     * Jwt constructor.
     *
     * @param \DouglasDC3\Kong\Kong $kong
     * @param \DouglasDC3\Kong\Model\Consumer  $consumer
     */
    public function __construct($kong, $consumer)
    {
        parent::__construct($kong);
        $this->consumer = $consumer;
    }

    /**
     * List all keys
     *
     * @return KeyAuthConsumer[]|\Illuminate\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list()
    {
        return $this->listCall("consumers/{$this->consumer->id}/key-auths", KeyAuthConsumer::class, []);
    }

    /**
     * Find a key
     *
     * @param $id
     *
     * @return \DouglasDC3\Kong\Model\Plugin\KeyAuthConsumer
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find($id)
    {
        return new KeyAuthConsumer($this->kong->getClient()->get("consumers/{$this->consumer->id}/key-auths/$id"), $this->kong);
    }

    /**
     * Create a new JWT token
     *
     * @param null   $key
     *
     * @return KeyAuthConsumer
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($key = null)
    {
        if (!($key instanceof KeyAuthConsumer)) {
            $key = new KeyAuthConsumer($key);
        }

        return new KeyAuthConsumer($this->kong->getClient()->post("consumers/{$this->consumer->id}/key-auths", $key->toArray()), $this->kong);
    }
}
