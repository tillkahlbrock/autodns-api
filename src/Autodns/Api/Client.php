<?php

namespace Autodns\Api;

use Autodns\Api\Client\Method\Provider;
use Autodns\Api\Client\Request;
use Autodns\Api\Client\Response;
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

    /**
     * @param XmlDelivery $delivery
     * @param Info $accountInfo
     */
    public function __construct(XmlDelivery $delivery, Info $accountInfo)
    {
        $this->delivery = $delivery;
        $this->accountInfo = $accountInfo;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function call(Request $request)
    {
        $request->setAuth($this->accountInfo->getAuthInfo());
        $url = $this->accountInfo->getUrl();
        $response = $this->delivery->send($url, $request);

        return new Response($response);
    }
}
