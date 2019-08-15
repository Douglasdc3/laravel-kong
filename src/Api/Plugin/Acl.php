<?php

namespace DouglasDC3\Kong\Api\Plugin;

use DouglasDC3\Kong\Api\KongApi;
use DouglasDC3\Kong\Model\Plugin\AclConsumer;

class Acl extends KongApi
{
    /**
     * @var \DouglasDC3\Kong\Model\Consumer
     */
    private $consumer;

    /**
     * ACL constructor.
     *
     * @param \DouglasDC3\Kong\Kong $kong
     * @param \DouglasDC3\Kong\Model\Consumer  $consumer
     */
    public function __construct($kong, $consumer)
    {
        parent::__construct($kong);
        $this->consumer = $consumer;
    }

    /**
     * List all ACL tokens
     *
     * @return AclConsumer[]|\Illuminate\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list()
    {
        return $this->listCall("consumers/{$this->consumer->id}/acls", AclConsumer::class, []);
    }

    /**
     * Find a ACL.
     *
     * @param $id
     *
     * @return \DouglasDC3\Kong\Model\Plugin\AclConsumer
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find($id)
    {
        return $this->getCall("consumers/{$this->consumer->id}/acls/$id", AclConsumer::class);
    }

    /**
     * Create a new ACL.
     *
     * @param $acl
     *
     * @return AclConsumer
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($acl)
    {
        if (!($acl instanceof AclConsumer)) {
            $acl = new AclConsumer([
                'group' => $acl
            ]);
        }

        return $this->postCall("consumers/{$this->consumer->id}/acls", $acl->toArray(), AclConsumer::class);
    }

    /**
     * Remove an ACL permission.
     *
     * @param string|AclConsumer $acl
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($acl)
    {
        if (!($acl instanceof AclConsumer)) {
            $acl = $this->list()->filter(function ($aclConsumer) use ($acl) {
                return $aclConsumer->group === $acl;
            })->first();
        }

        if (!$acl) {
            return false;
        }

        return $this->deleteCall("consumers/{$this->consumer->id}/acls/{$acl->id}");
    }
}
