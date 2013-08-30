<?php

namespace Autodns\Api;

use Autodns\Api\Client\Method\Provider;
use Autodns\Api\Client\Request;
use Autodns\Api\XmlDelivery;
use Autodns\Api\Account\Info;

class Client
{
    /**
     * @var XmlDelivery
     */
    private $delivery;

    /**
     * @var Info
     */
    private $accountInfo;

    public function __construct(XmlDelivery $delivery, Info $accountInfo)
    {
        $this->delivery = $delivery;
        $this->accountInfo = $accountInfo;
    }

    public function call($url, Request $request)
    {
        $request->setAuth($this->accountInfo->getAuthInfo());
        return $this->delivery->send($url, $request);
    }
}
