<?php

namespace DouglasDC3\Kong\Model\Plugin;

class JwtPlugin extends Plugin
{
    public $uri_param_names = [];
    public $cookie_names = [];
    public $claims_to_verify = ['exp'];
    public $key_claim_name = 'iss';
    public $secret_is_base64 = false;
    public $anonymous;
    public $run_on_preflight = true;

    /**
     * JwtPlugin constructor.
     *
     * @param $data
     */
    public function __construct($data = [])
    {
        parent::__construct('jwt', $data);

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
            'uri_param_names' => $this->uri_param_names,
            'cookie_names' => $this->cookie_names,
            'claims_to_verify' => $this->claims_to_verify,
            'key_claim_name' => $this->key_claim_name,
            'secret_is_base64' => $this->secret_is_base64,
            'anonymous' => $this->anonymous,
            'run_on_preflight' => $this->run_on_preflight,
        ];
    }
}
