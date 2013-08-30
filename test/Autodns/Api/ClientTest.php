<?php

use Autodns\Api\XmlDelivery;
use Autodns\Api\Account\Info;

class ClientTest extends TestCase
{
    const SOME_URL = 'some url';

    const SOME_METHOD_NAME = 'some method name';

    /**
     * @var XmlDelivery | TestDataBuilder_StubBuilder | PHPUnit_Framework_MockObject_MockObject
     */
    private $delivery;

    /**
     * @var Info | TestDataBuilder_StubBuilder | PHPUnit_Framework_MockObject_MockObject
     */
    private $accountInfo;

    protected function setUp()
    {
        parent::setUp();

        $this->delivery = $this->aStub('Autodns\Api\XmlDelivery');
        $this->accountInfo = $this->aStub('Autodns\Api\Account\Info')->with('getAuthInfo', array());
    }

    /**
     * @test
     */
    public function itShouldCallTheDeliveryWithTheGivenUrlAndRequest()
    {
        $url = self::SOME_URL;
        $request = $this->aStub('Autodns\Api\Client\Request')->build();

        $this->delivery = $this->delivery->build();
        $this->delivery
            ->expects($this->once())
            ->method('send')
            ->with($url, $request);

        $this->buildClient()->call($url, $request);
    }

    /**
     * @return Autodns\Api\Client
     */
    private function buildClient()
    {
        $client = $this->anObject('Autodns\Api\Client')->with(
            array(
                $this->delivery,
                $this->accountInfo
            )
        )->build();
        return $client;
    }
}
