<?php

namespace Autodns\Api\Client;


class Response 
{
    /**
     * @var array
     */
    private $payload;

    /**
     * @param array $payload
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getStatusType() == 'success';
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->payload['result']['status']['code'];
    }

    /**
     * @return string
     */
    public function getStatusType()
    {
        return $this->payload['result']['status']['type'];
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }
}
