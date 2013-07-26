<?php

namespace Jimdo\Autodns\Api\Client\Method;

use Jimdo\Autodns\Api\Client\Method;
use Jimdo\Autodns\Api\Exception\MethodNameDoesNotExist;

class Provider
{
    private $methodMapping;

    public function __construct()
    {
        $this->methodMapping = array(
            Method::DOMAIN_RENEW => 'Jimdo\Autodns\Api\Client\Method\DomainRenew'
        );
    }

    /**
     * @param string $methodName
     * @throws \Jimdo\Autodns\Api\Exception\MethodNameDoesNotExist
     * @return \Jimdo\Autodns\Api\Client\Method
     */
    public function fetchMethod($methodName)
    {
        if (!array_key_exists($methodName, $this->methodMapping)) {
            throw new MethodNameDoesNotExist();
        }

        return new $this->methodMapping[$methodName];
    }
}
