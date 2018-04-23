<?php

namespace DouglasDC3\Kong\Model\Plugin;

use DouglasDC3\Kong\Kong;
use Illuminate\Contracts\Support\Arrayable;

class KeyAuthConsumer implements Arrayable
{
    public $id;
    public $key;
    public $consumer_id;
    public $created_at;
    /**
     * @var \DouglasDC3\Kong\Kong
     */
    private $kong;

    /**
     * KeyAuthConsumer constructor.
     *
     * @param array                 $data
     * @param \DouglasDC3\Kong\Kong $kong
     */
    public function __construct($data = [], Kong $kong = null)
    {
        $this->kong = $kong;
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
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
            'key' => $this->key,
            'consumer_id' => $this->consumer_id,
            'created_at' => $this->created_at,
        ];
    }
}
