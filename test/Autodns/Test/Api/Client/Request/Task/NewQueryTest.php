<?php

namespace Autodns\Test\Api\Client\Request\Task;

use Autodns\Api\Client\Request\Task\NewQuery;
use Autodns\Api\Client\Request\Task\Query\Parameter;
use Autodns\Test\TestCase;

class NewQueryTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateASimpleOrExpression()
    {
        $a = new Parameter('time', 'gt', '12:00');
        $b = new Parameter('time', 'lt', '13:00');

        $query = NewQuery::build()
            ->orr($a, $b);

        $expectedArray = array(
            'or' => array(
                array(
                    'key' => 'time',
                    'operator' => 'gt',
                    'value' => '12:00'
                ),
                array(
                    'key' => 'time',
                    'operator' => 'lt',
                    'value' => '13:00'
                )
            )
        );

        $this->assertEquals($expectedArray, $query->asArray());
    }

    /**
     * @test
     */
    public function itShouldCreateASimpleAndExpression()
    {
        $a = new Parameter('money', 'gt', '100000000');
        $b = new Parameter('time', 'lt', '13:00');

        $query = NewQuery::build()
            ->andd($a, $b);

        $expectedArray = array(
            'and' => array(
                array(
                    'key' => 'money',
                    'operator' => 'gt',
                    'value' => '100000000'
                ),
                array(
                    'key' => 'time',
                    'operator' => 'lt',
                    'value' => '13:00'
                )
            )
        );

        $this->assertEquals($expectedArray, $query->asArray());
    }

    /**
     * @test
     */
    public function itShouldCreateANestedExpressionAOrBAndC()
    {
        $a = new Parameter('money', 'gt', '100000000');
        $b = new Parameter('time', 'gt', '12:00');
        $c = new Parameter('time', 'lt', '13:00');

        $query = NewQuery::build()
            ->orr($a)
            ->andd($b, $c);

        $expectedArray = array(#
            'or' => array(
                array(
                    'key' => 'money',
                    'operator' => 'gt',
                    'value' => '100000000'
                ),
                array(
                    'and' => array(
                        array(
                            'key' => 'time',
                            'operator' => 'gt',
                            'value' => '12:00'
                        ),
                        array(
                            'key' => 'time',
                            'operator' => 'lt',
                            'value' => '13:00'
                        )
                    )
                )
            )
        );

        $this->assertEquals($expectedArray, $query->asArray());
    }

    /**
     * @test
     */
    public function itShouldCreateANestedExpressionAAndBOrC()
    {
        $a = new Parameter('money', 'gt', '100000000');
        $b = new Parameter('time', 'gt', '12:00');
        $c = new Parameter('time', 'lt', '13:00');

        $query = NewQuery::build()
            ->andd($a)
            ->orr($b, $c);

        $expectedArray = array(#
            'and' => array(
                array(
                    'key' => 'money',
                    'operator' => 'gt',
                    'value' => '100000000'
                ),
                array(
                    'or' => array(
                        array(
                            'key' => 'time',
                            'operator' => 'gt',
                            'value' => '12:00'
                        ),
                        array(
                            'key' => 'time',
                            'operator' => 'lt',
                            'value' => '13:00'
                        )
                    )
                )
            )
        );

        $this->assertEquals($expectedArray, $query->asArray());
    }
}
