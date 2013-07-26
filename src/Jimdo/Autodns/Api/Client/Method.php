<?php

namespace Jimdo\Autodns\Api\Client;


interface Method
{
    public function createRequest(array $requestData);
}
