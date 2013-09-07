<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task;

class DomainRecoverInquire implements Task
{
    /**
     * @var string[]
     */
    private $keys;
    /**
     * @var QueryInterface
     */
    private $query;

    /**
     * @var string[]
     */
    private $view;

    public function asArray()
    {
        $array = array('code' => '0105005');

        if ($this->view) {
            $array['view'] = $this->view;
        }

        if ($this->keys) {
            $array['key'] = $this->keys;
        }


        if ($this->query) {
            $array['where'] = $this->query->asArray();
        }

        return $array;
    }

    /**
     * @param $view
     * @return $this
     */
    public function withView(array $view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @param array $keys
     * @return $this
     */
    public function withKeys(array $keys)
    {
        $this->keys = $keys;
        return $this;
    }

    /**
     * @param QueryInterface $query
     * @return $this
     */
    public function withQuery(QueryInterface $query)
    {
        $this->query = $query;
        return $this;
    }
}
