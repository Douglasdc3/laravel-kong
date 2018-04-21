<?php

namespace DouglasDC3\Kong\Model;

use DouglasDC3\Kong\Kong;
use Illuminate\Contracts\Support\Arrayable;

class Certificate implements Arrayable
{
    /**
     * @var string Certificate file
     */
    public $cert;

    /**
     * @var string Private key (PEM)
     */
    public $key;

    /**
     * @var array list of SNI domains associated with the current certificate (optional)
     */
    public $snis = [];

    /**
     * @var int Created at timestamp. Null when certificated yet.
     */
    public $created_at;
    /**
     * @var \DouglasDC3\Kong\Kong
     */
    private $kong;

    /**
     * Certificate constructor.
     *
     * @param string|array $cert
     * @param string $key
     * @param array  $snis
     */
    public function __construct($cert, $key = null, array $snis = [])
    {
        if (is_array($cert)) {
            foreach ($cert as $key => $value) {
                $this->$key = $value;
            }

            return;
        }

        if ($key instanceof Kong) {
            $this->kong = $key;
        }

        $this->cert = $cert;
        $this->key = $key;
        $this->snis = $snis;
    }


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'cert' => $this->cert,
            'key' => $this->key,
            'snis' => $this->snis,
            'created_at' => $this->created_at,
        ];
    }
}
