<?php

namespace DouglasDC3\Kong\Api\Plugin;

use DouglasDC3\Kong\Api\KongApi;
use DouglasDC3\Kong\Model\Plugin\KeyAuthConsumer;

class KeyAuth extends KongApi
{
    /**
     * @var \DouglasDC3\Kong\Model\Consumer
     */
    private $consumer;

    /**
     * Key Auth constructor.
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
        return $this->listCall("consumers/{$this->consumer->id}/key-auth", KeyAuthConsumer::class, []);
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
        return $this->getCall("consumers/{$this->consumer->id}/key-auth/$id", KeyAuthConsumer::class);
    }

    /**
     * Add a new key.
     *
     * @param null   $key
     *
     * @return KeyAuthConsumer
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($key = null)
    {
        if (!($key instanceof KeyAuthConsumer)) {
            if (is_array($key)) {
                $key = new KeyAuthConsumer($key);
            } else {
                $key = new KeyAuthConsumer(['key' => $key]);
            }
        }

        return $this->postCall("consumers/{$this->consumer->id}/key-auth", $key->toArray(), KeyAuthConsumer::class);
    }
}
