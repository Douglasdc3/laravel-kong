<?php

namespace DouglasDC3\Kong\Api\Plugin;

use DouglasDC3\Kong\Api\KongApi;
use DouglasDC3\Kong\Model\Plugin\JwtConsumer as JwtModel;

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
     * @return JwtModel[]|\Illuminate\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list()
    {
        return $this->listCall("consumers/{$this->consumer->id}/jwt", JwtModel::class, []);
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
        return new JwtModel($this->kong->getClient()->get("consumers/{$this->consumer->id}/jwt/$id"), $this->kong);
    }

    /**
     * Create a new JWT token
     *
     * @param null   $key
     * @param string $algo
     * @param null   $secret
     * @param null   $rsa
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($key = null, $algo = 'HS256', $secret = null, $rsa = null)
    {
        if (!($key instanceof JwtModel)) {
            $key = new JwtModel([
                'key' => $key,
                'algorithm' => $algo,
                'secret' => $secret,
                'rsa_public_key' => $rsa,
            ]);
        }

        return new JwtModel($this->kong->getClient()->post("consumers/{$this->consumer->id}/jwt", $key->toArray()), $this->kong);
    }
}
