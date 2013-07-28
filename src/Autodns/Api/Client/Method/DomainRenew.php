<?php

namespace Autodns\Api\Client\Method;

use Autodns\Api\Client\Method;

class DomainRenew implements Method
{
    public function createTask(array $requestData)
    {
        return array(
            'code'   => '0101003',
            'domain' => array(
                'name'                => $requestData['name'],
                'payable'             => $requestData['payable'],
                'period'              => $requestData['period'],
                'remove_cancellation' => $requestData['remove_cancellation']
            )
        );
    }
}
