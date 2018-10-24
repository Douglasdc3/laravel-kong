<?php

namespace DouglasDC3\Kong\Api\Plugin;

use DouglasDC3\Kong\Api\KongApi;
use DouglasDC3\Kong\Model\Plugin\JwtConsumer;

class Jwt extends KongApi
{
    /**
     * @var \DouglasDC3\Kong\Model\Consumer
     */
    private $consumer;

    const HS256 = 'HS256';
    const RS256 = 'RS256';

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
     * List all JWT tokens
     *
     * @return JwtConsumer[]|\Illuminate\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list()
    {
        return $this->listCall("consumers/{$this->consumer->id}/jwt", JwtConsumer::class, []);
    }

    /**
     * Find a JWT token
     *
     * @param $id
     *
     * @return \DouglasDC3\Kong\Model\Plugin\JwtConsumer
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find($id)
    {
        return $this->getCall("consumers/{$this->consumer->id}/jwt/$id", JwtConsumer::class);
    }

    /**
     * Create a new JWT token
     *
     * @param null   $key
     * @param string $algo
     * @param null   $secret
     * @param null   $rsa
     *
     * @return JwtConsumer
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($key = null, $algo = 'HS256', $secret = null, $rsa = null)
    {
        if (!($key instanceof JwtConsumer)) {
            $key = new JwtConsumer([
                'key' => $key,
                'algorithm' => $algo,
                'secret' => $secret,
                'rsa_public_key' => $rsa,
                'consumer_id' => $this->consumer->id,
            ]);
        }

        return $this->postCall("consumers/{$this->consumer->id}/jwt", $key->toArray(), JwtConsumer::class);
    }

    /**
     * Delete a JWT token
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->deleteCall("consumers/{$this->consumer->id}/jwt/$id", JwtConsumer::class);
    }

}
