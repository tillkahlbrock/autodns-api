<?php

namespace Autodns\Test\Api\Client;

use Autodns\Api\Client\Request\Task\Query;
use Autodns\Api\Client\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldReturnAnArrayRepresentationOfARequest()
    {
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

        $request = new Request($task);

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
            )
        );

        $output = $request->asArray();

        $this->assertEquals($expectedRequestArray, $output);
    }
}
