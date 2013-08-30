<?php

namespace Autodns\Api\Client\Request\Task\Query;


use Autodns\Api\Client\Request\Task\Query;

class OrQuery implements Query
{
    private $left;

    private $right;

    public function __construct(Query $left, Query $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    public function asArray()
    {
        return array('or' => array($this->left->asArray(), $this->right->asArray()));
    }
}
