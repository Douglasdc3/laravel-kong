<?php

namespace DouglasDC3\Kong\Api;

use DouglasDC3\Kong\Kong;
use DouglasDC3\Kong\Model\Plugin\JwtPlugin;
use DouglasDC3\Kong\Model\Plugin\Plugin;

class Plugins extends KongApi
{
    /**
     * @var null
     */
    private $parent;

    /**
     * Plugins constructor.
     *
     * @param \DouglasDC3\Kong\Kong $kong
     * @param null                  $parent
     */
    public function __construct(Kong $kong, $parent = null)
    {
        parent::__construct($kong);
        $this->parent = $parent;
    }

    /**
     * @return static
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list()
    {
        return collect($this->kong->getClient()->get($this->buildUrl())['data'])
            ->map(function ($item) {
                return $this->mapPlugin($item);
            });
    }

    /**
     * @param \DouglasDC3\Kong\Model\Plugin\Plugin $plugin
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(Plugin $plugin)
    {
        $plugin->setParent($this->parent);

        $class = get_class($plugin);

        return new $class($this->kong->getClient()->post($this->buildUrl(), $plugin->toArray()));
    }

    /**
     * @param $id
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($id)
    {
        return $this->deleteCall($this->buildUrl() . '/' . $id);
    }

    private function buildUrl()
    {
        return $this->parent->getPath() . '/plugins';
    }

    private function mapPlugin($item)
    {
        if ($item['name'] === 'jwt') {
            return new JwtPlugin($item);
        }

        return $item;
    }
}
