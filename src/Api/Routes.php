<?php

namespace DouglasDC3\Kong\Api;

use DouglasDC3\Kong\Model\Route;

class Routes extends KongApi
{
    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array|\Illuminate\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list($offset = 0, $limit = 100)
    {
        return $this->listCall('routes', Route::class, $this->paginateParams($offset, $limit));
    }

    /**
     * @param $id
     *
     * @return \DouglasDC3\Kong\Model\Route
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find($id)
    {
        return new Route($this->kong->getClient()->get("routes/$id"), $this->kong);
    }

    /**
     * @param \DouglasDC3\Kong\Model\Route $route
     *
     * @return \DouglasDC3\Kong\Model\Route
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(Route $route)
    {
        return new Route($this->kong->getClient()->post("routes", $route->toArray()), $this->kong);
    }

    /**
     * @param \DouglasDC3\Kong\Model\Route $route
     *
     * @return \DouglasDC3\Kong\Model\Route
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patch(Route $route)
    {
        return new Route($this->kong->getClient()->patch("routes/$route->id", $route->toArray()), $this->kong);
    }

    /**
     * @param $id
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($id)
    {
        return $this->kong->getClient()->delete("routes/$id")->getStatusCode() === 204;
    }
}
