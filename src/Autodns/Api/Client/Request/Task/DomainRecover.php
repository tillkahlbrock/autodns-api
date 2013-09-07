<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task;

class DomainRecover implements Task
{
    private $domain;
    private $ctid;
    private $replyTo;

    public function asArray()
    {
        $array = array(
            'code' => '0101005',
            'domain' => array('name' => $this->domain)
        );

        if (isset($this->ctid)) {
            $array['ctid'] = $this->ctid;
        }

        if (isset($this->replyTo)) {
            $array['reply_to'] = $this->replyTo;
        }

        return $array;
    }

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
     * @param $ctid
     * @return $this
     */
    public function withCtid($ctid)
    {
        $this->ctid = $ctid;
        return $this;
    }

    /**
     * @param $replyTo
     * @return $this
     */
    public function replyTo($replyTo)
    {
        $this->replyTo = $replyTo;
        return $this;
    }
}
