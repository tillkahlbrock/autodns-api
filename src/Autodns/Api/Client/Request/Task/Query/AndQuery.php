<?php

namespace Autodns\Api\Client\Request\Task\Query;

use Autodns\Api\Client\Request\Task\QueryInterface;

class AndQuery implements QueryInterface
{
    private $left;

    private $right;

    public function __construct(QueryInterface $left, QueryInterface $right = null)
    {
        $this->left = $left;
        $this->right = $right;
    }

    public function asArray()
    {
        $array = array(
            'and' => array($this->left->asArray())
        );

        if ($this->right) {
            $array['and'][] = $this->right->asArray();
        }

        return $array;
    }
}
