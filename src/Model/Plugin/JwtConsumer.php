<?php

namespace DouglasDC3\Kong\Model\Plugin;

use DouglasDC3\Kong\Kong;
use Illuminate\Contracts\Support\Arrayable;

class JwtConsumer implements Arrayable
{
    public $id;
    public $algorithm;
    public $key;
    public $secret;
    public $consumer_id;
    public $rsa_public_key;
    public $created_at;
    /**
     * @var \DouglasDC3\Kong\Kong
     */
    private $kong;

    /**
     * Jwt constructor.
     *
     * @param array                 $data
     * @param \DouglasDC3\Kong\Kong $kong
     */
    public function __construct($data = [], Kong $kong = null)
    {
        $this->kong = $kong;
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->key = $value;
            }
        }
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'algorithm' => $this->algorithm,
            'key' => $this->key,
            'secret' => $this->secret,
            'consumer_id' => $this->consumer_id,
            'rsa_public_key' => $this->rsa_public_key,
            'created_at' => $this->created_at,
        ];
    }
}
