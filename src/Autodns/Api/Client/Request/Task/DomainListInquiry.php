<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task;

class DomainListInquiry implements Task
{
    /**
     * @var string[]
     */
    private $keys;
    /**
     * @var Query
     */
    private $query;

    /**
     * @var string[]
     */
    private $view;

    public function __construct(array $view, array $keys, Query $query)
    {
        $this->view = $view;
        $this->keys = $keys;
        $this->query = $query;

    }

    public function asArray()
    {
        // TODO: Implement asArray() method.
    }
}
