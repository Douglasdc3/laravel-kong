<?php

namespace DouglasDC3\Kong\Api;

use DouglasDC3\Kong\Kong;
use DouglasDC3\Kong\Model\Route;
use DouglasDC3\Kong\Model\Service;

class Routes extends KongApi
{
    /**
     * @var string|null
     */
    private $service;

    /**
     * Routes constructor.
     *
     * @param \DouglasDC3\Kong\Kong          $kong
     * @param \DouglasDC3\Kong\Model\Service $service
     */
    public function __construct(Kong $kong, Service $service = null)
    {
        parent::__construct($kong);
        $this->service = $service ? rtrim($service->getPath(), '/') . '/' : '';
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array|\Illuminate\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list($offset = 0, $limit = 100)
    {
        return $this->listCall("{$this->service}routes", Route::class, $this->paginateParams($offset, $limit));
    }

    /**
     * @param $id
     *
     * @return \DouglasDC3\Kong\Model\Route
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find($id)
    {
        return new Route($this->kong->getClient()->get("{$this->service}routes/$id"), $this->kong);
    }

    /**
     * @param \DouglasDC3\Kong\Model\Route $route
     *
     * @return \DouglasDC3\Kong\Model\Route
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(Route $route)
    {
        return new Route($this->kong->getClient()->post("{$this->service}routes", $route->toArray()), $this->kong);
    }

    /**
     * @param \DouglasDC3\Kong\Model\Route $route
     *
     * @return \DouglasDC3\Kong\Model\Route
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(Route $route)
    {
        return new Route($this->kong->getClient()->patch("{$this->service}routes/$route->id", $route->toArray()), $this->kong);
    }

    /**
     * @param $id
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($id)
    {
        return $this->deleteCall("{$this->service}routes/$id");
    }
}
