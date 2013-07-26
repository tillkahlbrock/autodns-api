<?php

namespace Jimdo\Autodns\Api\Account;


interface Info 
{
    public function getContext();

    public function getPassword();

    public function getUsername();
}