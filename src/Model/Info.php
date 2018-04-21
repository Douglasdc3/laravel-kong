<?php

namespace DouglasDC3\Kong\Model;

use Illuminate\Contracts\Support\Arrayable;

class Info implements Arrayable
{
    /**
     * @var string Kong version string.
     */
    public $version;
    /**
     * @var string Hostname.
     */
    public $hostname;

    /**
     * Info constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->version = $data['version'] ?? '';
        $this->hostname = $data['hostname'] ?? '';
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'version' => $this->version,
            'hostname' => $this->hostname,
        ];
    }
}
