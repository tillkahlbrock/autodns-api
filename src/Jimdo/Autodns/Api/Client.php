<?php

namespace Jimdo\Autodns\Api;

use Jimdo\Autodns\Api\Client\Method\Provider;
use Jimdo\Autodns\Api\XmlDelivery;

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

        $request = $method->createRequest($payload);

        return $this->delivery->send($url, $request);
    }
}
