<?php

namespace Autodns\Api\Client\Method;

use Autodns\Api\Client\Method;
use Autodns\Api\Exception\RequestDataParameterMissing;

class DomainInquiry implements Method
{
    public function createTask(array $requestData)
    {
        if (!isset($requestData['name'])) {
            throw new RequestDataParameterMissing();
        }

        $task = array(
            'code'                 => '0105',
            'domain'               => array(
                'name' => $requestData['name']
            )
        );

        if (isset($requestData['key'])) {
            $task['key'] = $requestData['key'];
        }

        if (isset($requestData['show_contact_details'])) {
            $task['show_contact_details'] = $requestData['show_contact_details'];
        }

        return $task;
    }
}
