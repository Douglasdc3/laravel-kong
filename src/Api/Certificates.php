<?php

namespace DouglasDC3\Kong\Api;

use DouglasDC3\Kong\Model\Certificate;

class Certificates extends KongApi
{
    /**
     * Retrieve a list of Certificates
     *
     * @param int $offset
     * @param int $limit
     *
     * @return Certificate[]|\Illuminate\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list(int $offset = 0, int $limit = 100)
    {
        return $this->listCall('/certificates', Certificate::class, $this->paginateParams($offset, $limit));
    }

    /**
     * Find a certificate by ID or SNI identifier.
     *
     * @param $id ID or SNI identifier
     *
     * @return \DouglasDC3\Kong\Model\Certificate
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find($id)
    {
        return new Certificate($this->kong->getClient()->get("certificates/$id"), $this->kong);
    }

    /**
     * Create a new Certificate.
     *
     * @param \DouglasDC3\Kong\Model\Certificate $certificate
     *
     * @return \DouglasDC3\Kong\Model\Certificate
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(Certificate $certificate)
    {
        return new Certificate($this->kong->getClient()->post('certificates', $certificate->toArray()), $this->kong);
    }

    /**
     * Update a certificate.
     *
     * @param \DouglasDC3\Kong\Model\Certificate $certificate
     *
     * @return \DouglasDC3\Kong\Model\Certificate
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patch(Certificate $certificate)
    {
        return new Certificate($this->kong->getClient()->patch("certificates/$certificate->id", $certificate->toArray()), $this->kong);
    }

    /**
     * Delete a certificate.
     *
     * @param int|string $id SNI or id
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($id)
    {
        return $this->deleteCall("certificates/$id");
    }
}
