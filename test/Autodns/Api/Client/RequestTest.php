<?php

use Tool\QueryBuilder;

class RequestTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldReturnAnArrayRepresentationOfARequest()
    {
        $query = QueryBuilder::build();
        $query = $query->addOr(
            $query->addAnd(
                array('name', 'like', '*.at'),
                array('created', 'lt', '2012-12-*')
            ),
            array('name', 'like', '*.de')
        );

        $request = \Tool\RequestBuilder::build()
            ->withReplyTo('replyTo@this.com')
            ->withCtid('some identifier');
        $request
            ->ofType('DomainListInquiry')
            ->withView(array('offset' => 0, 'limit' => 20, 'children' => 0))
            ->withKeys(array('created', 'payable'))
            ->withQuery($query);

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
