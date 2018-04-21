<?php

namespace DouglasDC3\Kong\Model\Plugin;

use DouglasDC3\Kong\Kong;
use Illuminate\Contracts\Support\Arrayable;

class AclConsumer implements Arrayable
{
    public $id;
    public $created_at;
    public $group;
    public $consumer_id;

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
    public function __construct($data, Kong $kong = null)
    {
        $this->kong = $kong;

        if (is_string($data)) {
            $this->group = $data;
            return;
        }

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
            'created_at' => $this->created_at,
            'group' => $this->group,
            'consumer_id' => $this->consumer_id,
        ];
    }
}
