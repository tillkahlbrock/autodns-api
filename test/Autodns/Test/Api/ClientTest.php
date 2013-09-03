<?php

namespace Autodns\Test\Api;

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
    public function itShouldSetTheAuthToTheRequest()
    {
        $authInfo = array('user', 'password', 2);
        $this->accountInfo->with('getAuthInfo', $authInfo);

        $request = $this->aRequest();
        $request
            ->expects($this->once())
            ->method('setAuth')
            ->with($this->identicalTo($authInfo));

        $this->buildClient()->call($request);
    }

    /**
     * @test
     */
    public function itShouldCallTheDeliveryWithTheUrlFromTheAccountInfoAndTheGivenRequest()
    {
        $url = self::SOME_URL;
        $request = $this->aRequest();

        $this->accountInfo->with('getUrl', $url);

        $this->delivery = $this->delivery->build();
        $this->delivery
            ->expects($this->once())
            ->method('send')
            ->with($url, $request);

        $this->buildClient()->call($request);
    }

    /**
     * @test
     */
    public function itShouldReturnAResponseBuildFromTheDeliveryResponse()
    {
        $deliveryResponse = array('some' => 'response');

        $this->delivery->with('send', $deliveryResponse);

        $response = $this->buildClient()->call($this->aRequest());

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
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function aRequest()
    {
        return $this->aStub('Autodns\Api\Client\Request')->build();
    }
}
