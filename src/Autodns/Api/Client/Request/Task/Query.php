<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task\Query\AndQuery;
use Autodns\Api\Client\Request\Task\Query\OrQuery;
use Autodns\Api\Client\Request\Task\Query\Parameter;

class Query
{
    /**
     * @return Query
     */
    public static function build()
    {
        return new Query();
    }

    /**
     * @param array | QueryInterface $left
     * @param array | QueryInterface $right
     * @return QueryInterface
     */
    public function addOr($left, $right)
    {
        if (is_array($left)) {
            $left = new Parameter($left[0], $left[1], $left[2]);
        }

        if (is_array($right)) {
            $right = new Parameter($right[0], $right[1], $right[2]);
        }

        return new OrQuery($left, $right);
    }

    /**
     * @param array | QueryInterface $left
     * @param array | QueryInterface $right
     * @return QueryInterface
     */
    public function addAnd($left, $right = null)
    {
        if (is_array($left)) {
            $left = new Parameter($left[0], $left[1], $left[2]);
        }

        if (is_array($right)) {
            $right = new Parameter($right[0], $right[1], $right[2]);
        }

        return new AndQuery($left, $right);
    }
}
