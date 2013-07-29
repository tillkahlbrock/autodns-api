<?php

namespace Autodns\Api\Account;


class Info
{
    private $username;

    private $password;

    private $context;

    public function __construct($username, $password, $context)
    {
        $this->username = $username;
        $this->password = $password;
        $this->context = $context;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getAuthInfo()
    {
        return array(
            'auth' => array(
                'user' => $this->username,
                'password' => $this->password,
                'context' => $this->context
            )
        );
    }
}