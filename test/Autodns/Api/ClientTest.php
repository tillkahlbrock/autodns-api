<?php

use Autodns\Api\Client\Method\Provider;
use Autodns\Api\XmlDelivery;
use Autodns\Api\Account\Info;

class ClientTest extends TestCase
{
    const SOME_URL = 'some url';

    const SOME_METHOD_NAME = 'some method name';

    /**
     * @var Provider | TestDataBuilder_StubBuilder | PHPUnit_Framework_MockObject_MockObject
     */
    private $methodProvider;

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

        $this->methodProvider = $this->aStub('Autodns\Api\Client\Method\Provider')
            ->with('fetchMethod', $this->aMethod());
        $this->delivery = $this->aStub('Autodns\Api\XmlDelivery');
        $this->accountInfo = $this->aStub('Autodns\Api\Account\Info')->with('getAuthInfo', array());
    }

    /**
     * @test
     */
    public function itShouldFetchTheMethodByTheMethodName()
    {
        $methodName = self::SOME_METHOD_NAME;

        $this->methodProvider = $this->methodProvider->build();
        $this->methodProvider
            ->expects($this->once())
            ->method('fetchMethod')
            ->with($methodName);

        $this->buildClient()->call($methodName, self::SOME_URL, $this->somePayload());
    }

    /**
     * @test
     */
    public function itShouldCreateATaskWithTheFetchedMethod()
    {
        $payload = $this->somePayload();

        $method = $this->aMethod()->build();
        $method
            ->expects($this->once())
            ->method('createTask')
            ->with($payload);

        $this->methodProvider->with('fetchMethod', $method);

        $this->buildClient()->call(self::SOME_METHOD_NAME, self::SOME_URL, $payload);
    }

    /**
     * @test
     */
    public function itShouldFetchTheAuthInfo()
    {
        $this->accountInfo = $this->accountInfo->build();
        $this->accountInfo
            ->expects($this->once())
            ->method('getAuthInfo');

        $this->buildClient()->call(self::SOME_METHOD_NAME, self::SOME_URL, $this->somePayload());
    }

    /**
     * @test
     */
    public function itShouldCallTheDeliveryWithTheGivenUrl()
    {
        $url = self::SOME_URL;

        $this->delivery = $this->delivery->build();
        $this->delivery
            ->expects($this->once())
            ->method('send')
            ->with($url, $this->anything(), $this->anything());

        $this->buildClient()->call(self::SOME_METHOD_NAME, $url, $this->somePayload());
    }

    /**
     * @test
     */
    public function itShouldSendTheTask()
    {
        $task = array('some' => 'task');
        $method = $this->aMethod()->with('createTask', $task);
        $this->methodProvider->with('fetchMethod', $method);

        $this->delivery = $this->delivery->build();
        $this->delivery
            ->expects($this->once())
            ->method('send')
            ->with($this->anything(), $task, $this->anything());

        $this->buildClient()->call(self::SOME_METHOD_NAME, self::SOME_URL, $this->somePayload());
    }

    /**
     * @test
     */
    public function itShouldSendAuthInfo()
    {
        $authInfo = array('some' => 'auth');
        $this->accountInfo->with('getAuthInfo', $authInfo);

        $this->delivery = $this->delivery->build();
        $this->delivery
            ->expects($this->once())
            ->method('send')
            ->with($this->anything(), $this->anything(), $authInfo);

        $this->buildClient()->call(self::SOME_METHOD_NAME, self::SOME_URL, $this->somePayload());
    }

    /**
     * @test
     */
    public function itShouldReturnTheResponseFromTheDelivery()
    {
        $response = 'some response';

        $this->delivery->with('send', $response);

        $this->assertSame($response, $this->buildClient()->call(self::SOME_METHOD_NAME, self::SOME_URL, $this->somePayload()));
    }

    /**
     * @return \Autodns\Api\Client
     */
    private function buildClient()
    {
        return $this->anObject('\Autodns\Api\Client')
            ->with(
                array(
                    $this->methodProvider,
                    $this->delivery,
                    $this->accountInfo
                )
            )->build();
    }

    private function somePayload()
    {
        return array();
    }

    /**
     * @return TestDataBuilder_StubBuilder
     */
    private function aMethod()
    {
        return $this->aStub('Autodns\Api\Client\Method')->with('createTask', array());
    }
}
