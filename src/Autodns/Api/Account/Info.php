<?php

namespace Autodns\Api\Account;

class Info
{
    private $url;

    private $username;

    private $password;

    private $context;

    public function __construct(
        $url,
        $username,
        $password,
        $context
    )
    {
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
        $this->context = $context;
    }

    public function getUrl()
    {
        return $this->url;
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
            'user' => $this->username,
            'password' => $this->password,
            'context' => $this->context
        );
    }
}