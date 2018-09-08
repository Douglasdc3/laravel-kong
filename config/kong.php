<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Enable kong
    |--------------------------------------------------------------------------
    |
    | Toggles if kong should be used in the first place. Wen true the real
    | Kong api will be called. When this value is set to false all calls
    | to kong are ignored and not send. This is useful for development.
    |
    */

    'enabled' => env('KONG_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Base URI
    |--------------------------------------------------------------------------
    |
    | Sets Kong Admin base uri. Should be in full URI including protocol
    | including the port number if when you are not using the default
    | port for this protocol. Valid value is http://localhost:8001
    |
    */

    'base_uri' => env('KONG_BASE_URI', 'http://localhost:8001'),

    /*
    |--------------------------------------------------------------------------
    | Global query scope
    |--------------------------------------------------------------------------
    |
    | A list of query parameters added to each request. This list should
    | include key value pairs which are valid query params. Everything
    | which includes special characters should first be url encded.
    |
    */

    'query' => [],

    /*
    |--------------------------------------------------------------------------
    | Global header scope
    |--------------------------------------------------------------------------
    |
    | A list of header parameters added to each request. This list should
    | include key value paris which are set as headers onto each request
    | this can be used to handle authentication for admin users on kong
    |
    */

    'headers' => [],

];

