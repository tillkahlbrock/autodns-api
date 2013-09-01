<?php
namespace Autodns\Api\Client\Request\Task\Query;

use Autodns\Api\Client\Request\Task\QueryInterface;

class Parameter implements QueryInterface
{
    private $key;

    private $operator;

    private $value;

    public function __construct($key, $operator, $value)
    {
        $this->key = $key;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function asArray()
    {
        return array(
            'key' => $this->key,
            'operator' => $this->operator,
            'value' => $this->value
        );
    }
}
