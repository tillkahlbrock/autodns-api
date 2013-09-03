<?php

namespace Autodns\Api\Client\Request;


class TaskBuilder 
{
    /**
     * @param string $type
     * @return Task
     */
    public static function build($type)
    {
        $className = 'Autodns\Api\Client\Request\Task\\' . $type;
        return new $className();
    }
}
