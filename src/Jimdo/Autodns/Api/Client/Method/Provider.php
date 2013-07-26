<?php

namespace Jimdo\Autodns\Api\Client\Method;

interface Provider
{
    /**
     * @param string $methodName
     * @return \Jimdo\Autodns\Api\Client\Method
     */
    public function fetchMethod($methodName);
}
