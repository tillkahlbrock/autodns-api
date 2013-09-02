<?php

namespace Autodns\Tool;

use Autodns\Api\Client\Request\Task\Query;

class QueryBuilder
{
    /**
     * @return Query
     */
    public static function build()
    {
        return new Query();
    }
}
