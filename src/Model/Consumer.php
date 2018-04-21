<?php

namespace DouglasDC3\Kong\Model;

use DouglasDC3\Kong\Api\Plugin\Acl;
use DouglasDC3\Kong\Api\Plugin\Jwt;
use DouglasDC3\Kong\Kong;
use Illuminate\Contracts\Support\Arrayable;

class Consumer implements Arrayable
{
    /**
     * Consumer ID.
     *
     * @var string UUID
     */
    public $id;

    /**
     * Consumer Username (unique).
     *
     * @var string UUID
     */
    public $username;

    /**
     * Custom ID (external).
     *
     * @var string custom (external) id
     */
    public $custom_id;

    /**
     * Timestamp.
     *
     * @var int
     */
    public $created_at;

    /**
     * @var \DouglasDC3\Kong\Kong
     */
    private $kong;

    /**
     * Consumer constructor.
     *
     * @param array                      $data
     * @param \DouglasDC3\Kong\Kong|null $kong
     */
    public function __construct(array $data = [], Kong $kong = null)
    {
        $this->kong = $kong;
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * JWT Associated with this consumer.
     *
     * @return \DouglasDC3\Kong\Api\Plugin\Jwt
     */
    public function jwt()
    {
        return new Jwt($this->kong, $this);
    }

    /**
     * ACL Groups associated to this Consumer.
     */
    public function acl()
    {
        return new Acl($this->kong, $this);
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
            'username' => $this->username,
            'custom_id' => $this->custom_id,
            'created_at' => $this->created_at,
        ];
    }
}
