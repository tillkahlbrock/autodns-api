<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task;

class DomainRecover implements Task
{
    private $values;

    public function asArray()
    {
        $array = array(
            'code' => '0101005',
            'domain' => array('name' => $this->values['domain'])
        );

        if (isset($this->values['ctid'])) {
            $array['ctid'] = $this->values['ctid'];
        }

        if (isset($this->values['reply_to'])) {
            $array['reply_to'] = $this->values['reply_to'];
        }

        return $array;
    }

    /**
     * @param $view
     * @return $this
     */
    public function withView(array $view)
    {
        return $this;
    }

    /**
     * @param array $keys
     * @return $this
     */
    public function withKeys(array $keys)
    {
        return $this;
    }

    /**
     * @param QueryInterface $query
     * @return $this
     */
    public function withQuery(QueryInterface $query)
    {
        return $this;
    }

    /**
     * @param array $values
     * @return Task
     */
    public function withValue(array $values)
    {
        $this->values = $values;
        return $this;
    }
}
