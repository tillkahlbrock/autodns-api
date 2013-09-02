<?php

namespace Autodns\Test\Tool;

use Autodns\Api\Client\Request\Task\Query\AndQuery;
use Autodns\Api\Client\Request\Task\Query\OrQuery;
use Autodns\Api\Client\Request\Task\Query\Parameter;
use Autodns\Api\Client\Request;
use Autodns\Test\TestCase;
use Autodns\Tool\RequestBuilder;

class RequestBuilderTest extends TestCase
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
        $query = new OrQuery(
            new AndQuery(
                new Parameter('name', 'like', '*.at'),
                new Parameter('created', 'lt', '2012-12-*')
            ),
            new Parameter('name', 'like', '*.de')
        );

        $expectedRequest = new Request(
            new Request\Task\DomainListInquiry(
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
