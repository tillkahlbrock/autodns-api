<?php

namespace Jimdo\Autodns\Api;

use Jimdo\Autodns\Api\Account\Info;

class XmlDelivery
{
    private $xmlWriter;

    private $sender;

    /**
     * @var Account\Info
     */
    private $accountInfo;

    /**
     * @param string $url
     * @param array $request
     * @return \Buzz\Message\MessageInterface
     */
    public function send($url, array $request)
    {
        $this->xmlWriter = new \XMLWriter();
        $this->xmlWriter->openMemory();
        $xml = $this->convertToXml($request);

        $this->sender = new \Buzz\Browser(new \Buzz\Client\Curl());

        $response = $this->sender->call($url, \Buzz\Message\RequestInterface::METHOD_POST, array(), $xml);

        $responseRepresentation = $this->createResponseRepresentation($response);
    }

    private function convertToXml($request)
    {
        $username = $this->accountInfo->getUsername();
        $password = $this->accountInfo->getPassword();
        $context = $this->accountInfo->getContext();
        return '';
    }

    private function createResponseRepresentation(\Buzz\Message\MessageInterface $response)
    {
        return array();
    }
}
