<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task;

class DomainInquire implements Task
{
    private $domain;
    private $keys;

    /**
     * @param $domain
     * @return $this
     */
    public function domain($domain)
    {
        $this->domain = $domain;
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
     * @return array
     */
    public function asArray()
    {
        $array = array(
            'code' => '0105',
            'domain' => array('name' => $this->domain)
        );

        if ($this->keys) {
            $array['key'] = $this->keys;
        }
        return $array;
    }
}
