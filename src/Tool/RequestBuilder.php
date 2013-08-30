<?php

namespace Tool;


use Autodns\Api\Client\Request;

class RequestBuilder
{
    /**
     * @return Request
     */
    public static function build()
    {
        return new Request();
    }
}
