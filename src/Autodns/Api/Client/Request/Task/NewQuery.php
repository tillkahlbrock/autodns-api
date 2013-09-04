<?php

namespace Autodns\Api\Client\Request\Task;


class NewQuery
{
    private $query = array();

    public static function build()
    {
        return new self();
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return $this->query;
    }

    public function orr(QueryInterface $left, QueryInterface $right = null)
    {
        $this->query['or'][] = $left->asArray();
        $this->query['or'][] = $right === null ? null : $right->asArray();
        return $this;
    }

    public function andd(QueryInterface $left, QueryInterface $right)
    {
        if (isset($this->query['or']) && $this->query['or'][1] === null) {
            $this->query['or'][1] = array('and' => array($left->asArray(), $right->asArray()));
        } else {
            $this->query['and'][] = $left->asArray();
            $this->query['and'][] = $right->asArray();
        }

        return $this;
    }
}
