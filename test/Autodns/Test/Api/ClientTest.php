<?php

namespace Autodns\Test\Api;

use Autodns\Api\Client\Request;
use Autodns\Api\XmlDelivery;
use Autodns\Api\Account\Info;
use Autodns\Test\TestCase;

class ClientTest extends TestCase
{
    const SOME_URL = 'some url';

    const SOME_METHOD_NAME = 'some method name';

    /**
     * @var XmlDelivery | \TestDataBuilder_StubBuilder | \PHPUnit_Framework_MockObject_MockObject
     */
    private $delivery;

    /**
     * @var Info | \TestDataBuilder_StubBuilder | \PHPUnit_Framework_MockObject_MockObject
     */
    private $accountInfo;

    protected function setUp()
    {
        parent::setUp();

        $this->delivery = $this->aStub('Autodns\Api\XmlDelivery')->with('send', array());
        $this->accountInfo = $this->aStub('Autodns\Api\Account\Info')->with('getAuthInfo', array());
    }

    /**
     * @test
     */
    public function itShouldSendARequestWithTheGivenTaskAndTheAuthInformation()
    {
        $task = new Request\Task\DomainListInquiry();
        $authInfo = array('user', 'password', 2);
        $this->accountInfo->with('getAuthInfo', $authInfo);

        $request = new Request($task);
        $request->setAuth($authInfo);

        $this->delivery = $this->delivery->build();
        $this->delivery
            ->expects($this->once())
            ->method('send')
            ->with($this->anything(), $request);

        $this->buildClient()->call($task);
    }

    /**
     * @test
     */
    public function itShouldCallTheDeliveryWithTheUrlFromTheAccountInfo()
    {
        $url = self::SOME_URL;
        $this->accountInfo->with('getUrl', $url);

        $this->delivery = $this->delivery->build();
        $this->delivery
            ->expects($this->once())
            ->method('send')
            ->with($url, $this->anything());

        $this->buildClient()->call($this->aTask());
    }

    /**
     * @test
     */
    public function itShouldReturnAResponseBuildFromTheDeliveryResponse()
    {
        $deliveryResponse = array('some' => 'response');

        $this->delivery->with('send', $deliveryResponse);

        $response = $this->buildClient()->call($this->aTask());

        $this->assertEquals($deliveryResponse, $response->getPayload());
    }

    /**
     * @return \Autodns\Api\Client
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

    /**
     * @return \Autodns\Api\Client\Request\Task | \PHPUnit_Framework_MockObject_MockObject
     */
    private function aTask()
    {
        $task = $this->aStub('Autodns\Api\Client\Request\Task')->build();
        return $task;
    }
}
