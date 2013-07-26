<?php

namespace Jimdo\Autodns\Api\Client;

interface Method
{
    const DOMAIN_RENEW = 'method.domain.renew';

    public function createTask(array $requestData);
}
