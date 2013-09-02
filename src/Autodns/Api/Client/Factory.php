<?php

namespace Autodns\Api\Client;


use Autodns\Api\Account\Info;
use Autodns\Api\Client;
use Autodns\Api\XmlDelivery;
use Buzz\Browser;
use Autodns\Tool\ArrayToXmlConverter;
use Autodns\Tool\XmlToArrayConverter;

class Factory
{
    public static function create(Info $accountInfo)
    {
        return new Client(
            new XmlDelivery(
                new ArrayToXmlConverter(),
                new Browser(),
                new XmlToArrayConverter()
            ),
            $accountInfo
        );
    }
}
