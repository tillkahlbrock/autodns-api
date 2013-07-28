<?php

namespace Autodns\Api;

use Autodns\Api\Client\Method\Provider;
use Autodns\Api\XmlDelivery;

class Client
{
    /**
     * @var Provider
     */
    private $methodProvider;

    /**
     * @var XmlDelivery
     */
    private $delivery;

    public function __construct(Provider $methodProvider, XmlDelivery $delivery)
    {
        $this->methodProvider = $methodProvider;
        $this->delivery = $delivery;
    }

    public function call($methodName, $url, array $payload)
    {
        $method = $this->methodProvider->fetchMethod($methodName);

        $task = $method->createTask($payload);

        return $this->delivery->send($url, $task);
    }
}
