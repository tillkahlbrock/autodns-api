<?php
namespace Autodns\Api\Client\Request\Task\Query;

use Autodns\Api\Client\Request\Task\Query;

class Parameter implements Query
{
    private $operator;

    private $value;

    public function __construct($operator, $value)
    {
        $this->operator = $operator;
        $this->value = $value;
    }

    public function asArray()
    {
        return array(
            'key' => array(
                'operator' => $this->operator,
                'value' => $this->value

            )
        );
    }
}
