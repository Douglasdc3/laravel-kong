<?php

namespace DouglasDC3\Kong\Api;

use DouglasDC3\Kong\Model\Consumer;

class Consumers extends KongApi
{
    /**
     * Fetch a list of consumers.
     *
     * @param int $offset
     * @param int $limit
     *
     * @return \Illuminate\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list(int $offset = 0, int $limit = 100)
    {
        return $this->listCall('consumers', Consumer::class, $this->paginateParams($offset, $limit));
    }

    /**
     * Retrieve consumer.
     *
     * @param string $id username or ID.
     *
     * @return \DouglasDC3\Kong\Model\Consumer
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find(string $id)
    {
        return new Consumer($this->kong->getClient()->get("consumers/$id"), $this->kong);
    }

    /**
     * Create a new consumer.
     *
     * @param \DouglasDC3\Kong\Model\Consumer $consumer
     *
     * @return \DouglasDC3\Kong\Model\Consumer
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(Consumer $consumer)
    {
        return new Consumer($this->kong->getClient()->post('consumers', $consumer->toArray()), $this->kong);
    }

    /**
     * Update a consumer.
     *
     * @param \DouglasDC3\Kong\Model\Consumer $consumer
     *
     * @return \DouglasDC3\Kong\Model\Consumer
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(Consumer $consumer)
    {
        return new Consumer($this->kong->getClient()->put('consumers', $consumer->toArray()), $this->kong);
    }

    /**
     * Delete a consumer by id or username.
     *
     * @param $id
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($id)
    {
        return $this->deleteCall("consumers/$id");
    }
}
