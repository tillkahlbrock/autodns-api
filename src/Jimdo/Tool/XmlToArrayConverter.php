<?php

namespace Jimdo\Tool;


interface XmlToArrayConverter 
{
    /**
     * @param string $xml
     * @return array
     */
    public function convert($xml);
}