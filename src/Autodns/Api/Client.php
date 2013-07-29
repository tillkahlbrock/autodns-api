<?php

namespace Autodns\Api;

use Autodns\Api\Client\Method\Provider;
use Autodns\Api\XmlDelivery;
use Autodns\Api\Account\Info;

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

    /**
     * @var Info
     */
    private $accountInfo;

    public function __construct(Provider $methodProvider, XmlDelivery $delivery, Info $accountInfo)
    {
        $this->methodProvider = $methodProvider;
        $this->delivery = $delivery;
        $this->accountInfo = $accountInfo;
    }

    public function call($methodName, $url, array $payload)
    {
        $method = $this->methodProvider->fetchMethod($methodName);

        $task = $method->createTask($payload);

        $authInfo = $this->accountInfo->getAuthInfo();

        return $this->delivery->send($url, $authInfo, $task);
    }
}
