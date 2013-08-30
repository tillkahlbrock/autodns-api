<?php

class RequestBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldBuildARequest()
    {
        $requestBuilder = new Tool\RequestBuilder();

//        $this->assertInstanceOf('Autodns\Api\Client\Request', $requestBuilder->build());
    }

    /**
     * @test
     */
    public function itShouldDo()
    {
        $expectedRequest = new Autodns\Api\Client\Request(
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

        $requestBuilder = new Tool\RequestBuilder();
        $actualRequest = $requestBuilder->build()
            ->ofType('DomainListInquiry')
            ->withView(array('offset' => 0, 'limit' => 20, 'children' => 0))
            ->withKeys(array('created', 'payable'))
            ->withQuery(
                array(
                    'or' => array(
                        'and' => array(
                            array('name', 'like', '*.at'),
                            array('created', 'lt', '2012-12-*')
                        ),
                        array('name', 'like', '*.de')
                    )
                )
            )
            ->withReplyTo('replyTo@this.com')
            ->withCtid('some identifier');

        $this->assertEquals($expectedRequest, $actualRequest);
    }
}
