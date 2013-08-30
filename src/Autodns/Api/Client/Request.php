<?php

namespace Autodns\Api\Client;

use Autodns\Api\Client\Request\Auth;
use Autodns\Api\Client\Request\Task;

class Request
{
    /**
     * @var Auth
     */
    private $auth;
    /**
     * @var Task
     */
    private $task;

    private $replyTo;

    private $ctid;

    public function __construct(Auth $auth, Task $task, $replyTo, $ctid)
    {
        $this->auth = $auth;
        $this->task = $task;
        $this->replyTo = $replyTo;
        $this->ctid = $ctid;
    }

    public function asArray()
    {
        $request = array(
            'auth' => $this->auth->asArray(),
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
