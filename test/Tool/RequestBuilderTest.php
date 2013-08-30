<?php

use Tool\RequestBuilder;

class RequestBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldBuildARequest()
    {
        $this->assertInstanceOf('Autodns\Api\Client\Request', RequestBuilder::build());
    }

    /**
     * @test
     */
    public function itShouldDo()
    {
        $query = new Autodns\Api\Client\Request\Task\Query\OrQuery(
            new Autodns\Api\Client\Request\Task\Query\AndQuery(
                new Autodns\Api\Client\Request\Task\Query\Parameter('name', 'like', '*.at'),
                new Autodns\Api\Client\Request\Task\Query\Parameter('created', 'lt', '2012-12-*')
            ),
            new Autodns\Api\Client\Request\Task\Query\Parameter('name', 'like', '*.de')
        );

        $expectedRequest = new Autodns\Api\Client\Request(
            new \Autodns\Api\Client\Request\Task\DomainListInquiry(
                array('offset' => 0, 'limit' => 20, 'children' => 0),
                array('created', 'payable'),
                $query
            ),
            'replyTo@this.com',
            'some identifier'
        );

        $actualRequest = RequestBuilder::build()
            ->withReplyTo('replyTo@this.com')
            ->withCtid('some identifier');
        $actualRequest
            ->ofType('DomainListInquiry')
            ->withView(array('offset' => 0, 'limit' => 20, 'children' => 0))
            ->withKeys(array('created', 'payable'))
            ->withQuery($query);

        $this->assertEquals($expectedRequest, $actualRequest);
    }
}
