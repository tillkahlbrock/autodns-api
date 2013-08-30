<?php

namespace Autodns\Api\Client\Request;


use Autodns\Api\Client\Request\Task\Query;

interface Task
{
    /**
     * @return array
     */
    public function asArray();

    /**
     * @param array $view
     * @return Task
     */
    public function withView(array $view);

    /**
     * @param array $keys
     * @return Task
     */
    public function withKeys(array $keys);

    /**
     * @param Query $query
     * @return Task
     */
    public function withQuery(Query $query);
}
