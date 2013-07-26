<?php

namespace Jimdo\Tool;


class XmlToArrayConverter
{
    /**
     * @param string $xmlString
     * @return array
     */
    public function convert($xmlString)
    {
        $xml = simplexml_load_string($xmlString);
        $json = json_encode($xml);
        return json_decode($json, true);
    }
}