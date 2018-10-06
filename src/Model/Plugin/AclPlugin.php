<?php

namespace DouglasDC3\Kong\Model\Plugin;

class AclPlugin extends Plugin
{
    public $whitelist = [];
    public $blacklist = [];

    /**
     * AclPlugin constructor.
     *
     * @param $data
     */
    public function __construct($data = [])
    {
        parent::__construct('acl', $data);

        $data = $data['config'] ?? $data;

        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Returns the current whitelist and blacklist.
     *
     * @return array
     */
    protected function configArray()
    {
        return [
            'whitelist' => $this->whitelist,
            'blacklist' => $this->blacklist,
        ];
    }
}
