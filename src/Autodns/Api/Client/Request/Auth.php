<?php

namespace Autodns\Api\Client\Request;

class Auth
{
    private $user;

    private $password;

    private $context;

    public function __construct($user, $password, $context)
    {
        $this->user = $user;
        $this->password = $password;
        $this->context = $context;
    }

    public function asArray()
    {
        return array();
    }
}
