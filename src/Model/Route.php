<?php

namespace DouglasDC3\Kong\Model;

use DouglasDC3\Kong\Api\Plugins;
use DouglasDC3\Kong\Kong;
use Illuminate\Contracts\Support\Arrayable;

class Route implements Arrayable
{
    public $id;
    public $created_at;
    public $updated_at;
    public $protocols = ['http', 'https'];
    public $methods = [];
    public $hosts = [];
    public $paths = [];
    public $regex_priority = 0;
    public $strip_path = true;
    public $preserve_host = false;
    public $service;
    /**
     * @var \DouglasDC3\Kong\Kong
     */
    private $kong;

    public function __construct(array $data = [], Kong $kong = null)
    {
        foreach ($data as $key => $value) {
            if ($key == 'service') continue;

            $this->$key = $value;
        }

        $this->service = $data['service'] instanceof Service ? $data['service'] : ($data['service']['id'] ?? null);
        $this->kong = $kong;
    }

    /**
     * Plugins associated with this route
     *
     * @return \DouglasDC3\Kong\Api\Plugins
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
        return 'routes/' . $this->id;
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
            'updated_at' => $this->updated_at,
            'protocols' => $this->protocols,
            'methods' => $this->methods,
            'hosts' => $this->hosts,
            'paths' => $this->paths,
            'regex_priority' => $this->regex_priority,
            'strip_path' => $this->strip_path,
            'preserve_host' => $this->preserve_host,
            'service' => [
                'id' => $this->service instanceof Service ? $this->service->id : $this->service,
            ]
        ];
    }

    public function __toString()
    {
        return (string) $this->id;
    }
}
