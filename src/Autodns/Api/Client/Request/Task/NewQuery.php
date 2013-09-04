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
        return $this->addExpression('or', $left, $right);
    }

    public function andd(QueryInterface $left, QueryInterface $right = null)
    {
        return $this->addExpression('and', $left, $right);
    }

    private function setExpressionToMostRightBottomLeaf(&$query, $operator, $left, $right)
    {
        if (isset($query['or'])) {
            $rightOr = $query['or'][1];
            if ($rightOr === null) {
                $query['or'][1] = array($operator => array($left, $right));
                return true;
            } elseif(array_key_exists('and', $rightOr) || array_key_exists('or', $rightOr)) {
                return $this->setExpressionToMostRightBottomLeaf($rightAnd, $operator, $left, $right);
            } else {
                return false;
            }
        }

        if (isset($query['and'])) {
            $rightAnd = $query['and'][1];
            if ($rightAnd === null) {
                $query['and'][1] = array($operator => array($left, $right));
                return true;
            } elseif(array_key_exists('and', $rightAnd) || array_key_exists('or', $rightAnd)) {
                return $this->setExpressionToMostRightBottomLeaf($rightAnd, $operator, $left, $right);
            } else {
                return false;
            }
        }

        return false;
    }

    /**
     * @param $operator
     * @param QueryInterface $left
     * @param QueryInterface $right
     * @return $this
     */
    private function addExpression($operator, QueryInterface $left, QueryInterface $right = null)
    {
        $left = $left->asArray();
        $right = $right ? $right->asArray() : null;;

        if (!$this->setExpressionToMostRightBottomLeaf($this->query, $operator, $left, $right)) {
            $this->query[$operator][] = $left;
            $this->query[$operator][] = $right;
        }
        return $this;
    }
}
