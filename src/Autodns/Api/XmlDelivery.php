<?php

namespace Autodns\Api;

use Autodns\Api\Account\Info;
use Autodns\Api\Client\Request;
use Tool\ArrayToXmlConverter;
use Tool\XmlToArrayConverter;
use Buzz\Browser;
use Buzz\Message\MessageInterface;

class XmlDelivery
{
    /**
     * @var \Tool\ArrayToXmlConverter
     */
    private $arrayXmlConverter;

    /**
     * @var \Buzz\Browser
     */
    private $sender;

    /**
     * @var \Tool\XmlToArrayConverter
     */
    private $xmlToArrayConverter;

    public function __construct(
        ArrayToXmlConverter $arrayXmlConverter,
        Browser $sender,
        XmlToArrayConverter $xmlToArrayConverter
    )
    {
        $this->arrayXmlConverter = $arrayXmlConverter;
        $this->sender = $sender;
        $this->xmlToArrayConverter = $xmlToArrayConverter;
    }

    /**
     * @param string $url
     * @param Client\Request $request
     * @return string
     */
    public function send($url, Request $request)
    {
        $xml = $this->arrayXmlConverter->convert($request->asArray());

        $response = $this->sender->post($url, array(), $xml);

        return $this->xmlToArrayConverter->convert($response->getContent());
    }
}
