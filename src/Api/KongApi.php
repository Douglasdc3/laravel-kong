<?php

namespace DouglasDC3\Kong\Api;

use DouglasDC3\Kong\Kong;

abstract class KongApi
{
    /**
     * @var \DouglasDC3\Kong\Http\HttpClient
     */
    protected $kong;

    /**
     * KongApi constructor.
     *
     * @param \DouglasDC3\Kong\Kong $kong
     */
    public function __construct(Kong $kong)
    {
        $this->kong = $kong;
    }

    /**
     * @param $url
     * @param $class
     * @param $query
     *
     * @return \Illuminate\Support\Collection|array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function listCall($url, $class, $query)
    {
        return collect($this->kong->getClient()->get($url, $query)['data'])
            ->map(function ($item) use ($class) {
                return new $class($item, $this->kong);
            });
    }

    /**
     * @param $url
     * @param $class
     *
     * @return \Illuminate\Contracts\Support\Arrayable of type $class
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getCall($url, $class)
    {
        return new $class($this->kong->getClient()->get($url), $this->kong);
    }

    /**
     * @param $url
     * @param $data
     * @param $class
     *
     * @return \Illuminate\Contracts\Support\Arrayable of type $class
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postCall($url, $data, $class)
    {
        return new $class($this->kong->getClient()->post($url, $data), $this->kong);
    }

    /**
     * @param $url
     * @param $data
     * @param $class
     *
     * @return \Illuminate\Contracts\Support\Arrayable of type $class
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patchCall($url, $data, $class)
    {
        return new $class($this->kong->getClient()->patch($url, $data), $this->kong);
    }

    /**
     * Delete a resource.
     *
     * @param $url
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function deleteCall($url)
    {
        return $this->kong->getClient()->delete($url)->getStatusCode() === 204;
    }

    /**
     * Build
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    protected function paginateParams($offset = 0, $limit = 100)
    {
        $pagination = ['size' => $limit];

        if ($offset > 0) {
            $pagination['offset'];
        }

        return $pagination;
    }
}
