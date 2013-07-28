<?php

use Buzz\Message\RequestInterface;

class XmlDeliveryTest extends TestCase 
{
    const SOME_URL = 'some-url';

    const SOME_XML = 'some xml';

    /**
     * @var Tool\ArrayToXmlConverter | TestDataBuilder_StubBuilder | PHPUnit_Framework_MockObject_MockObject
     */
    private $arrayToXmlConverter;

    /**
     * @var Autodns\Api\Account\Info | TestDataBuilder_StubBuilder | PHPUnit_Framework_MockObject_MockObject
     */
    private $accountInfo;

    /**
     * @var Buzz\Browser | TestDataBuilder_StubBuilder | PHPUnit_Framework_MockObject_MockObject
     */
    private $sender;

    /**
     * @var Tool\XmlToArrayConverter | TestDataBuilder_StubBuilder | PHPUnit_Framework_MockObject_MockObject
     */
    private $xmlToArrayConverter;

    protected function setUp()
    {
        parent::setUp();

        $this->arrayToXmlConverter = $this->aStub('Tool\ArrayToXmlConverter');
        $this->accountInfo = $this->aStub('Autodns\Api\Account\Info');
        $this->sender = $this->aStub('Buzz\Browser')->with('post', $this->aResponse());
        $this->xmlToArrayConverter = $this->aStub('Tool\XmlToArrayConverter');
    }

    /**
     * @test
     */
    public function itShouldConvertTheRequestToXml()
    {
        $this->arrayToXmlConverter = $this->arrayToXmlConverter->build();
        $this->arrayToXmlConverter
            ->expects($this->once())
            ->method('convert');

        $this->buildDelivery()->send(self::SOME_URL, $this->someTask());
    }

    /**
     * @test
     */
    public function itShouldSendTheGeneratedXmlToTheGivenUrl()
    {
        $url = self::SOME_URL;
        $xml = self::SOME_XML;

        $this->arrayToXmlConverter->with('convert', $xml);

        $this->sender = $this->sender->build();
        $this->sender
            ->expects($this->once())
            ->method('post')
            ->with($url, $this->anything(), $xml);

        $this->buildDelivery()->send($url, $this->someTask());
    }

    /**
     * @test
     */
    public function itShouldConvertTheXmlResponseToAnArrayRepresentation()
    {
        $xml = self::SOME_XML;
        $response = $this->aResponse()->with('getContent', $xml);

        $this->sender->with('post', $response);

        $this->xmlToArrayConverter = $this->xmlToArrayConverter->build();
        $this->xmlToArrayConverter
            ->expects($this->once())
            ->method('convert')
            ->with($xml);

        $this->buildDelivery()->send(self::SOME_URL, $this->someTask());
    }

    /**
     * @test
     */
    public function itShouldReturnTheConvertedResponse()
    {
        $convertedResponse = array('some' => 'thing');

        $this->xmlToArrayConverter->with('convert', $convertedResponse);

        $this->assertSame($convertedResponse, $this->buildDelivery()->send(self::SOME_URL, $this->someTask()));
    }

    /**
     * @return Autodns\Api\XmlDelivery
     */
    private function buildDelivery()
    {
        return $this->anObject('Autodns\Api\XmlDelivery')
            ->with(
                array(
                    $this->arrayToXmlConverter,
                    $this->accountInfo,
                    $this->sender,
                    $this->xmlToArrayConverter
                )
            )->build();
    }

    /**
     * @return array
     */
    private function someTask()
    {
        return array(
            'some'  => 'weired',
            'array' => 'structure'
        );
    }

    /**
     * @return TestDataBuilder_StubBuilder
     */
    private function aResponse()
    {
        return $this->aStub('Buzz\Message\MessageInterface')->with('getContent', self::SOME_XML);
    }
}
