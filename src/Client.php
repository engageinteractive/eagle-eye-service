<?php

namespace App\EagleEyeService;

use GuzzleHttp\Client as HttpClient;

class Client
{
    protected $base;
    protected $options;
    protected $methods = ['GET', 'POST'];
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function get()
    {
        return $this->request('GET', $endpoint);
    }

    public function post($endpoint, $payload = [], $queryParams = [])
    {
        return $this->request('POST', $endpoint, $payload, $queryParams);
    }

    protected function request($method, $endpoint, $payload = [], $queryParams = [])
    {
        if (!in_array($method, $this->methods))
        {
            throw new EagleEyeException($method . ' is not a valid method [Use: ' . implode(', ', $this->methods) . ']');
        }

        $client = $this->getHttpClient();

        if ($method == 'POST')
        {
            $this->setJsonBody($payload);
        }

        if ($queryParams)
        {
            $this->setQueryParameters($queryParams);
        }

        $this->setHeaders();

        $this->setAuthentication();

        return $client->request($method, $endpoint, $this->options);
    }

    protected function getHttpClient()
    {
        return new HttpClient([
            'base_uri' => $this->base,
        ]);
    }

    protected function setHeaders()
    {
        $this->options['headers'] = [
                'Cache-Control' => 'no-cache',
                'Content-Type' => 'application/json'
            ];
    }

    protected function setAuthentication()
    {
        $this->options['auth'] = $this->auth->getAuth();
    }

    protected function setQueryParameters($queryParams)
    {
        $this->options['query'] = $queryParams;
    }

    protected function setJsonBody($payload)
    {
        $this->options['body'] = json_encode($payload);
    }
}
