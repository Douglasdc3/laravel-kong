<?php

namespace DouglasDC3\Kong\Model;

use DouglasDC3\Kong\Kong;
use DouglasDC3\Kong\Api\Routes;
use DouglasDC3\Kong\Api\Plugins;
use Illuminate\Contracts\Support\Arrayable;

class Service implements Arrayable
{
    /** @var string */
    const URI_REGEX = '/(https?):\/\/([A-z0-9\-\.]*)(:?[0-9]*)(.*)/';
    /** @var int */
    const DEFAULT_PORT = 80;

    public $id;
    public $name;
    public $protocol = 'http';
    public $host;
    public $port = self::DEFAULT_PORT;
    public $path = '/';
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
     *
     * @param                            $data
     * @param \DouglasDC3\Kong\Kong|null $kong
     */
    public function __construct($data, Kong $kong = null)
    {
        $this->kong = $kong;

        if (is_string($data)) {
            $this->setUri($data);
            return;
        }

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $matches = [];
        preg_match(self::URI_REGEX, $uri, $matches);

        $this->protocol = $matches[1];
        $this->host = $matches[2];
        $this->port = empty($matches[3]) ? self::DEFAULT_PORT : (int)ltrim($matches[3], ':');
        $this->path = '/' . ltrim($matches[4], '/');
    }


    /**
     * Plugins associated with the given service.
     *
     * @return \DouglasDC3\Kong\Api\Plugins
     */
    public function plugins()
    {
        return new Plugins($this->kong, $this);
    }

    /**
     * Routes associated with the given service.
     *
     * @return \DouglasDC3\Kong\Api\Routes
     */
    public function routes()
    {
        return new Routes($this->kong, $this);
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'protocol' => $this->protocol,
            'host' => $this->host,
            'port' => $this->port,
            'path' => $this->path,
            'retries' => $this->retries,
            'connect_timeout' => $this->connect_timeout,
            'write_timeout' => $this->write_timeout,
            'read_timeout' => $this->read_timeout,
        ];
    }

    /**
     * Return the id when calling to string to make it easier
     * To use the object in a url path
     *
     * @return string Service ID
     */
    public function __toString()
    {
        return $this->id;
    }
}
