<?php

class RequestTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldReturnAnArrayRepresentationOfARequest()
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

        $expectedRequestArray = array(
            'auth' => array(),
            'task' => array(
                'code' => '0105',
                'view' => array(
                    'offset' => 0,
                    'limit' => 20,
                    'children' => 0
                ),
                'key' => array('created', 'payable'),
                'where' => array(
                    'or' => array(
                        array(
                            'and' => array(
                                array(
                                    'key' => 'name',
                                    'operator' => 'like',
                                    'value' => '*.at'
                                ),
                                array(
                                    'key' => 'created',
                                    'operator' => 'lt',
                                    'value' => '2012-12-*'
                                )
                            )
                        ),
                        array(
                            'key' => 'name',
                            'operator' => 'like',
                            'value' => '*.de'
                        )
                    )
                )
            ),
            'replyTo' => 'replyTo@this.com',
            'ctid' => 'some identifier'
        );

        $output = $request->asArray();

        $this->assertEquals($expectedRequestArray, $output);
    }
}
