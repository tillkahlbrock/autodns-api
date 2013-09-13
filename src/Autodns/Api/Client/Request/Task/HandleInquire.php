<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task;

class HandleInquire implements Task
{
    private $handleId;
    private $alias;

    /**
     * @param $handleId
     * @return $this
     */
    public function handleId($handleId)
    {
        $this->handleId = $handleId;
        return $this;
    }

    /**
     * @param $alias
     * @return $this
     */
    public function alias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        $array = array(
            'code' => '0304',
            'handle' => array()
        );

        if ($this->handleId) {
            $array['handle']['id'] = $this->handleId;
        }

        if ($this->alias) {
            $array['handle']['alias'] = $this->alias;
        }

        return $array;
    }
}
