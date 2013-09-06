<?php

namespace Autodns\Test\Api;

use Autodns\Api\Account\Info;
use Autodns\Api\Client;
use Autodns\Api\XmlDelivery;
use Autodns\Test\TestCase;
use Autodns\Tool\ArrayToXmlConverter;
use Autodns\Api\Client\Request\Task\Query;
use Autodns\Api\Client\Request;
use Autodns\Tool\XmlToArrayConverter;

class ClientIntegrationTest extends TestCase
{
    const SOME_URL = 'some url';

    /**
     * @test
     */
    public function itShouldMakeADomainInquireListCall()
    {
        $taskName = 'DomainInquireList';
        $responseXml = $this->getResponseXml($taskName);
        $expectedRequest = $this->getExpectedRequestXml($taskName);
        $expectedResult = new Client\Response(
            array(
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
            )
        );

        $fakeResponse = $this->aStub('Buzz\Message\MessageInterface')->with('getContent', $responseXml);

        $sender = $this->aStub('Buzz\Browser')->with('post', $fakeResponse)->build();
        $sender
            ->expects($this->once())
            ->method('post')
            ->with($this->anything(), $this->anything(), $expectedRequest);

        $client = $this->buildClient($sender);

        $query = Query::build();
        $query = $query->addOr(
            $query->addAnd(
                array('name', 'like', '*.at'),
                array('created', 'lt', '2012-12-*')
            ),
            array('name', 'like', '*.de')
        );

        $task = Request\TaskBuilder::build('DomainInquireList')
            ->withView(array('offset' => 0, 'limit' => 20, 'children' => 0))
            ->withKeys(array('created', 'payable'))
            ->withQuery($query);

        $this->assertEquals($expectedResult, $client->call($task));
    }

    /**
     * @test
     */
    public function itShouldMakeADomainRecoverInquireCall()
    {
        $taskName = 'DomainRecoverInquire';

        $responseXml = $this->getResponseXml($taskName);
        $expectedRequest = $this->getExpectedRequestXml($taskName);

        $expectedResult = new Client\Response(
            array(
                'result' => array(
                    'data' => array(
                        'summary' => '1',
                        'restore' => array(
                            'name' => 'example.com',
                            'expire' => '2013-07-13 15:24:39',
                            'payable' => '2013-07-13 15:24:39',
                            'action' => 'RESTORE',
                            'owner' => array(
                                'user' => 'customer2',
                                'context' => '4'
                            ),
                            'created' => '2009-07-13 15:24:39'
                        )
                    ),
                    'status' => array(
                        'text' => 'Die wiederherstellbaren Domains wurden erfolgreich ermittelt.',
                        'type' => 'success',
                        'code' => 'S0105005'
                    )
                ),
                'stid' => '20130906-xxx-44444'
            )
        );

        $fakeResponse = $this->aStub('Buzz\Message\MessageInterface')->with('getContent', $responseXml);

        $sender = $this->aStub('Buzz\Browser')->with('post', $fakeResponse)->build();
        $sender
            ->expects($this->once())
            ->method('post')
            ->with($this->anything(), $this->anything(), $expectedRequest);

        $client = $this->buildClient($sender);

        $query = Query::build()->addAnd(array('name', 'eq', 'example.com'));

        $task = Request\TaskBuilder::build($taskName)
            ->withView(array('offset' => 0, 'limit' => 1, 'children' => 0))
            ->withKeys(array('created', 'payable', 'expire'))
            ->withQuery($query);

        $this->assertEquals($expectedResult, $client->call($task));
    }

    /**
     * @test
     */
    public function itShouldMakeADomainRecoverCall()
    {
        $taskName = 'DomainRecover';

        $responseXml = $this->getResponseXml($taskName);
        $expectedRequest = $this->getExpectedRequestXml($taskName);

        $expectedResult = new Client\Response(
            array(
                'result' => array(
                    'data' => array(),
                    'status' => array(
                        'code' => 'N0101005',
                        'type' => 'notify',
                        'object' => array(
                            'type' => 'domain',
                            'value' => 'example.com'
                        )
                    )
                )
            )
        );

        $fakeResponse = $this->aStub('Buzz\Message\MessageInterface')->with('getContent', $responseXml);

        $sender = $this->aStub('Buzz\Browser')->with('post', $fakeResponse)->build();
        $sender
            ->expects($this->once())
            ->method('post')
            ->with($this->anything(), $this->anything(), $expectedRequest);

        $client = $this->buildClient($sender);

        $task = Request\TaskBuilder::build($taskName)
            ->withValue(
                array(
                    'domain' => 'example.com',
                    'reply_to' => 'some@body.com',
                    'ctid' => 'some identifier'
                )
            );

        $this->assertEquals($expectedResult, $client->call($task));
    }

    /**
     * @param $taskName
     * @return string
     */
    private function getResponseXml($taskName)
    {
        return file_get_contents(__DIR__ . '/testData/' . $taskName . '_response.xml');
    }

    /**
     * @param $taskName
     * @return string
     */
    private function getExpectedRequestXml($taskName)
    {
        return file_get_contents(__DIR__ . '/testData/' . $taskName . '_request.xml');
    }

    /**
     * @param $sender
     * @return Client
     */
    private function buildClient($sender)
    {
        $client = new Client(
            new XmlDelivery(
                new ArrayToXmlConverter(),
                $sender,
                new XmlToArrayConverter()
            ),
            new Info(self::SOME_URL, 'user', 'password', 4)
        );
        return $client;
    }
}
