<?php

namespace DouglasDC3\Kong\Model\Plugin;

class KeyAuthPlugin extends Plugin
{
    public $key_names = [];
    public $key_in_body = false;
    public $hide_credentials = false;
    public $anonymous;
    public $run_on_preflight = true;

    /**
     * JwtPlugin constructor.
     *
     * @param $data
     */
    public function __construct($data = [])
    {
        parent::__construct('key-auth', $data);

        $data = $data['config'] ?? $data;

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function configArray()
    {
        return [
            'key_names' => $this->key_names,
            'key_in_body' => $this->key_in_body,
            'hide_credentials' => $this->hide_credentials,
            'anonymous' => $this->anonymous,
            'run_on_preflight' => $this->run_on_preflight,
        ];
    }
}
