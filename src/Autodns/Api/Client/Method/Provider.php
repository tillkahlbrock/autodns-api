<?php

namespace Autodns\Api\Client\Method;

use Autodns\Api\Client\Method;
use Autodns\Api\Exception\MethodNameDoesNotExist;

class Provider
{
    private $methodMapping;

    public function __construct()
    {
        $this->methodMapping = array(
            Method::DOMAIN_RENEW => 'Autodns\Api\Client\Method\DomainRenew'
        );
    }

    /**
     * @param string $methodName
     * @throws \Autodns\Api\Exception\MethodNameDoesNotExist
     * @return \Autodns\Api\Client\Method
     */
    public function fetchMethod($methodName)
    {
        if (!array_key_exists($methodName, $this->methodMapping)) {
            throw new MethodNameDoesNotExist();
        }

        return new $this->methodMapping[$methodName];
    }
}
