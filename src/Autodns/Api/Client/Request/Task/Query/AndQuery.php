<?php

namespace Autodns\Api\Client\Request\Task\Query;

use Autodns\Api\Client\Request\Task\QueryInterface;

class AndQuery implements QueryInterface
{
    private $left;

    private $right;

    public function __construct(QueryInterface $left, QueryInterface $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    public function asArray()
    {
        return array(
            'and' => array(
                $this->left->asArray(),
                $this->right->asArray()
            )
        );
    }
}
