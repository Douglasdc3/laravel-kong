<?php

namespace DouglasDC3\Kong\Api;

use DouglasDC3\Kong\Model\Service;

class Services extends KongApi
{
    /**
     * Paginate a list of Services.
     *
     * @param int $offset
     * @param int $limit
     *
     * @return Service[]|\Illuminate\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list($offset = 0, $limit = 100)
    {
        return $this->listCall('services', Service::class, $this->paginateParams($offset, $limit));
    }

    /**
     * Find a service by id or name.
     *
     * @param $id id or name of the service.
     *
     * @return \DouglasDC3\Kong\Model\Service
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find($id)
    {
        return new Service($this->kong->getClient()->get("services/$id"), $this->kong);
    }

    /**
     * Create a new service.
     *
     * @param \DouglasDC3\Kong\Model\Service $service
     *
     * @return \DouglasDC3\Kong\Model\Service
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(Service $service)
    {
        return new Service($this->kong->getClient()->post('services', $service->toArray()), $this->kong);
    }

    /**
     * Update a Service.
     *
     * @param \DouglasDC3\Kong\Model\Service $service
     *
     * @return \DouglasDC3\Kong\Model\Service
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patch(Service $service)
    {
        return new Service($this->kong->getClient()->patch("services/$service->id", $service->toArray()), $this->kong);
    }

    /**
     * Delete a Service.
     *
     * @param $id id or name of the service.
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($id)
    {
        return $this->deleteCall("services/$id");
    }
}
