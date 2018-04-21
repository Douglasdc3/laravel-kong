<?php

namespace DouglasDC3\Kong\Model;

use DouglasDC3\Kong\Api\Plugins;
use DouglasDC3\Kong\Kong;
use Illuminate\Contracts\Support\Arrayable;

class Service implements Arrayable
{
    public $name;
    public $protocol = 'http';
    public $host;
    public $port = 80;
    public $path;
    public $retries = 5;
    public $connect_timeout = 60000;
    public $write_timeout = 60000;
    public $read_timeout = 60000;
    /**
     * @var \DouglasDC3\Kong\Kong
     */
    private $kong;


    /**
     * Service constructor.
     */
    public function __construct($data, Kong $kong)
    {
        if (is_string($data)) {
            $matches = [];
            preg_match('/(https?)(?:\:\/\/)([A-z\.]*)(.*)/', $data, $matches);

            $this->protocol = $matches[1];
            $this->host = $matches[2];
            $this->path = $matches[3];

            return;
        }

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        $this->kong = $kong;
    }

    /**
     * @return
     */
    public function plugins()
    {
        return new Plugins($this->kong, $this);
    }


    /**
     * Get path of this resource.
     *
     * @return string
     */
    public function getPath()
    {
        return 'services/' . $this->id;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}
