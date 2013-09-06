<?php

namespace Autodns\Api\Client\Request;


use Autodns\Api\Client\Request\Task\QueryInterface;

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
     * @param QueryInterface $query
     * @return Task
     */
    public function withQuery(QueryInterface $query);

    /**
     * @param array $values
     * @return Task
     */
    public function withValue(array $values);
}
