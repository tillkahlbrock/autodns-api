<?php

namespace Autodns\Api\Client\Request\Task;


class Key 
{
    private $name;

    private $value;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}
