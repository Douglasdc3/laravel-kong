<?php

namespace DouglasDC3\Kong\Http;

use GuzzleHttp\Client;

class HttpClient
{
    /**
     * @var array
     */
    private $options;

    /**
     * HttpClient constructor.
     *
     * @param string $baseUrl
     * @param array  $options
     */
    public function __construct(string $baseUrl, array $options = [])
    {
        $this->options = $options;

        $this->client = new Client([
            'base_uri' => $baseUrl
        ]);
    }

    /**
     * @param       $url
     * @param array $query
     * @param array $headers
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($url, $query = [], $headers = [])
    {
        return $this->request('GET', $url, $query, [], $headers);
    }

    /**
     * @param       $url
     * @param array $body
     * @param array $headers
     * @param array $query
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($url, $body = [], $headers = [], $query = [])
    {
        return $this->request('POST', $url, $query, $body, $headers);
    }

    /**
     * @param       $url
     * @param array $body
     * @param array $headers
     * @param array $query
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put($url, $body = [], $headers = [], $query = [])
    {
        return $this->request('PUT', $url, $query, $body, $headers);
    }

    /**
     * @param       $url
     * @param array $body
     * @param array $headers
     * @param array $query
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patch($url, $body = [], $headers = [], $query = [])
    {
        return $this->request('PATCH', $url, $query, $body, $headers);
    }

    /**
     * @param       $url
     * @param array $body
     * @param array $headers
     * @param array $query
     *
     * @return \GuzzleHttp\Psr7\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($url, $body = [], $headers = [], $query = [])
    {
        return $this->request('DELETE', $url, $query, $body, $headers, false);
    }

    /**
     * @param       $verb
     * @param       $url
     * @param array $query
     * @param array $body
     * @param array $headers
     *
     * @return array|\GuzzleHttp\Psr7\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function request($verb, $url, $query = [], $body = [], $headers = [], $json = true)
    {
        if (! empty($body)) {
            $headers['Content-Type'] = 'application/json';
        }

        $response = $this->client->request($verb, $url, [
            'query' => array_merge($this->options['query'] ?? [], $query),
            'headers' => array_merge($this->options['headers'] ?? [], $headers),
            'json' => $body
        ]);

        return $json ? json_decode($response->getBody()->getContents(), true) : $response;
    }
}
