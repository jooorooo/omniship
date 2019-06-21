<?php

namespace Omniship\Http;

class Client
{
    /**
     * @var Curl
     */
    private $httpClient;

    public function __construct(Curl $httpClient = null)
    {
        $this->httpClient = $httpClient ?: new Curl();
    }
    /**
     * @param $method
     * @param $uri
     * @param array $headers
     * @param array $parameters
     * @return Curl
     */
    public function send($method, $uri, array $headers = [], array $parameters = null, $xml = null)
    {
        $request = $this->createRequest($method, $uri, $headers, $parameters, $xml);
        return $this->sendRequest($request);
    }
    /**
     * @param $method
     * @param $uri
     * @param array $headers
     * @param array $parameters
     * @param xml $parameters
     * @return Curl
     */
    public function createRequest($method, $uri, array $headers = [], array $parameters = null, $xml = null)
    {
        $this->httpClient->setMethod($method)
            ->setTarget($uri)
            ->setHeaders($headers);
        if($xml) {
            $this->httpClient->setXml($xml);
        } elseif($parameters) {
            $this->httpClient->setParams($parameters);
        }
        return $this->httpClient;
    }
    /**
     * @param  Curl $request
     * @return Curl
     */
    public function sendRequest(Curl $request) : Curl
    {
        $request->execute();
        return $request;
    }
    /**
     * Send a GET request.
     *
     * @param string $uri
     * @param array $headers
     * @param array $parameters
     * @return Curl
     */
    public function get($uri, array $headers = [], array $parameters = null)
    {
        return $this->send('GET', $uri, $headers, $parameters);
    }
    /**
     * Send a POST request.
     *
     * @param string $uri
     * @param array $headers
     * @param array $parameters
     * @return Curl
     */
    public function post($uri, array $headers = [], array $parameters = null)
    {
        return $this->send('POST', $uri, $headers, $parameters);
    }
    /**
     * Send a GET request.
     *
     * @param string $uri
     * @param array $headers
     * @param string $xml
     * @return Curl
     */
    public function getXml($uri, array $headers = [], $xml = null)
    {
        return $this->send('GET', $uri, $headers, null, $xml);
    }
    /**
     * Send a XML POST request.
     *
     * @param string $uri
     * @param array $headers
     * @param string $xml
     * @return Curl
     */
    public function postXml($uri, array $headers = [], $xml = null)
    {
        return $this->send('POST', $uri, $headers, null, $xml);
    }
}
