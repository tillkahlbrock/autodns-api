<?php

use Autodns\Api\Client;
use Autodns\Api\Client\Method;

class ClientIntegrationTest extends TestCase
{
    const SOME_URL = 'some url';

    /**
     * @test
     */
    public function itShouldWork()
    {
        $responseXml = $this->getResponseXml();
        $response = $this->aStub('Buzz\Message\MessageInterface')->with('getContent', $responseXml);
        $expectedRequest = $this->getExpectedRequestXml();
        $expectedResult = $this->getExpectedResultAsArray();

        $sender = $this->aStub('Buzz\Browser')->with('post', $response)->build();
        $sender
            ->expects($this->once())
            ->method('post')
            ->with($this->anything(), $this->anything(), $expectedRequest);

        $client = $this->buildClient($sender);

        $request = $this->buildRequest();

        $this->assertEquals($expectedResult, $client->call(self::SOME_URL, $request));
    }

    /**
     * @return string
     */
    private function getResponseXml()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<response>
    <result>
        <data>
            <summary>2</summary>
            <domain>
                <owner>
                    <user>customer</user>
                    <context>4</context>
                </owner>
                <name>example.com</name>
                <created>2005-06-16 16:47:50</created>
            </domain>
            <domain>
                <owner>
                    <user>customer2</user>
                    <context>4</context>
                </owner>
                <name>example.com</name>
                <created>2005-06-16 16:47:50</created>
                <domainsafe>true</domainsafe>
                <dnssec>false</dnssec>
            </domain>
        </data>
        <status>
            <text>Domaindaten wurden erfolgreich ermittelt.</text>
            <type>success</type>
            <code>S0105</code>
        </status>
    </result>
</response>
XML;
        return $xml;
    }

    /**
     * @return array
     */
    private function getExpectedResultAsArray()
    {
        $expectedResult = array(
            'result' => array(
                'data' => array(
                    'summary' => '2',
                    'domain' => array(
                        array(
                            'owner' => array(
                                'user' => 'customer',
                                'context' => '4'
                            ),
                            'name' => 'example.com',
                            'created' => '2005-06-16 16:47:50'
                        ),
                        array(
                            'owner' => array(
                                'user' => 'customer2',
                                'context' => '4'
                            ),
                            'name' => 'example.com',
                            'created' => '2005-06-16 16:47:50',
                            'domainsafe' => 'true',
                            'dnssec' => 'false'
                        )
                    )
                ),
                'status' => array(
                    'text' => 'Domaindaten wurden erfolgreich ermittelt.',
                    'type' => 'success',
                    'code' => 'S0105'
                )
            )
        );
        return $expectedResult;
    }

    /**
     * @return string
     */
    private function getExpectedRequestXml()
    {
        $expectedRequest = <<<RequestXml
<?xml version="1.0" encoding="UTF-8"?>
<request>
  <auth>
    <user>user</user>
    <password>password</password>
    <context>4</context>
  </auth>
  <task>
    <code>0105</code>
    <view>
      <offset>0</offset>
      <limit>20</limit>
      <children>0</children>
    </view>
    <key>created</key>
    <key>payable</key>
    <where>
      <or>
        <and>
          <key>name</key>
          <operator>like</operator>
          <value>*.at</value>
        </and>
        <and>
          <key>created</key>
          <operator>lt</operator>
          <value>2012-12-*</value>
        </and>
      </or>
      <or>
        <key>name</key>
        <operator>like</operator>
        <value>*.de</value>
      </or>
    </where>
  </task>
  <replyTo>replyTo@this.com</replyTo>
  <ctid>some identifier</ctid>
</request>

RequestXml;
        return $expectedRequest;
    }

    /**
     * @param $sender
     * @return Client
     */
    private function buildClient($sender)
    {
        $client = new Client(
            new Autodns\Api\XmlDelivery(
                new Tool\ArrayToXmlConverter(),
                $sender,
                new Tool\XmlToArrayConverter()
            ),
            new Autodns\Api\Account\Info('user', 'password', 4)
        );
        return $client;
    }

    /**
     * @return Client\Request
     */
    private function buildRequest()
    {
        $request = new Autodns\Api\Client\Request(
            new \Autodns\Api\Client\Request\Task\DomainListInquiry(
                array('offset' => 0, 'limit' => 20, 'children' => 0),
                array('created', 'payable'),
                new Autodns\Api\Client\Request\Task\Query\OrQuery(
                    new Autodns\Api\Client\Request\Task\Query\AndQuery(
                        new Autodns\Api\Client\Request\Task\Query\Parameter('name', 'like', '*.at'),
                        new Autodns\Api\Client\Request\Task\Query\Parameter('created', 'lt', '2012-12-*')
                    ),
                    new Autodns\Api\Client\Request\Task\Query\Parameter('name', 'like', '*.de')
                )
            ),
            'replyTo@this.com',
            'some identifier'
        );
        return $request;
    }
}
