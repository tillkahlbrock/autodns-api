<?php

class RequestTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldReturnAnArrayRepresentationOfARequest()
    {
        $request = new Autodns\Api\Client\Request(
            new \Autodns\Api\Client\Request\Auth('username', 'password', 'context'),
            new \Autodns\Api\Client\Request\Task\DomainListInquiry(
                array('offset' => 0, 'limit' => 20, 'children' => 0),
                array('created_at'),
                new Autodns\Api\Client\Request\Task\Query\AndQuery(
                    new Autodns\Api\Client\Request\Task\Query\Parameter('name', 'like', '*.at'),
                    new Autodns\Api\Client\Request\Task\Query\Parameter('created_at', 'lt', '2012-12-*')
                )
            ),
            'replyTo@this.com',
            'some identifier'
        );

        $expectedRequestArray = array(
            'auth' => array(
                'user' => 'username',
                'password' => 'password',
                'context' => 'context'
            ),
            'task' => array(
                'view' => array(
                    'offset' => 0,
                    'limit' => 20,
                    'children' => 0
                ),
                'key' => array('created_at'),
                'where' => array(
                    'and' => array(
                        array(
                            'key' => 'name',
                            'operator' => 'like',
                            'value' => '*.at'
                        ),
                        array(
                            'key' => 'created_at',
                            'operator' => 'lt',
                            'value' => '2012-12-*'
                        )
                    )
                )
            ),
            'replyTo' => 'replyTo@this.com',
            'ctid' => 'some identifier'
        );

        $this->assertEquals($expectedRequestArray, $request->asArray());
    }
}
