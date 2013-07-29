<?php

namespace Autodns\Api;

use Autodns\Api\Account\Info;
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
     * @param array $task
     * @param array $authInfo
     * @return string
     */
    public function send($url, array $task, array $authInfo)
    {
        $request = $this->buildRequest($authInfo, $task);

        $xml = $this->arrayXmlConverter->convert($request);

        $response = $this->sender->post($url, array(), $xml);

        return $this->xmlToArrayConverter->convert($response->getContent());
    }

    private function buildRequest($authInfo, $task)
    {
        return array_merge($authInfo, $task);
    }
}
