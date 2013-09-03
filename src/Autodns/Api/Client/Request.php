<?php

namespace Autodns\Api\Client;

use Autodns\Api\Client\Request\Auth;
use Autodns\Api\Client\Request\Task;

class Request
{
    /**
     * @var Task
     */
    private $task;

    private $replyTo;

    private $ctid;

    private $auth;

    /**
     * @return Request
     */
    public static function build()
    {
        return new Request();
    }

    public function __construct(Task $task = null, $replyTo = null, $ctid = null)
    {
        $this->task = $task;
        $this->replyTo = $replyTo;
        $this->ctid = $ctid;
        $this->auth = array();
    }

    /**
     * @param string $type
     * @return Task
     */
    public function ofType($type)
    {
        $className = 'Autodns\Api\Client\Request\Task\\' . $type;
        $this->task = new $className();
        return $this->task;
    }

    /**
     * @param $replyTo
     * @return $this
     */
    public function withReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
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

    public function getTask()
    {
        return $this->task;
    }

    public function setAuth(array $auth)
    {
        $this->auth = $auth;
    }

    public function getAuth()
    {
        return $this->auth;
    }

    public function asArray()
    {
        $request = array(
            'auth' => $this->auth,
            'task' => $this->task->asArray()
        );

        if($this->replyTo) {
            $request['replyTo'] = $this->replyTo;
        }

        if ($this->ctid) {
            $request['ctid'] = $this->ctid;
        }

        return $request;
    }
}
